<?php

namespace App\Http\Controllers;

use App\Models\FeeInvoice;
use App\Models\FeePayment;
use App\Models\FeeStructure;
use App\Models\SchoolClass;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class FeeInvoiceController extends Controller
{
    /**
     * Display a listing of invoices.
     */
    public function index(Request $request)
    {
        $query = FeeInvoice::with(['student', 'student.schoolClass']);

        if ($request->has('student_id') && $request->student_id) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->has('class_id') && $request->class_id) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('school_class_id', $request->class_id);
            });
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $invoices = $query->orderBy('issue_date', 'desc')->paginate(20);
        $classes = SchoolClass::all();

        return view('fees.invoices.index', compact('invoices', 'classes'));
    }

    /**
     * Show form to generate invoices (Bulk).
     */
    public function create()
    {
        $classes = SchoolClass::all();
        return view('fees.invoices.create', compact('classes'));
    }

    /**
     * Store generated invoices.
     */
    public function store(Request $request)
    {
        $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'student_id' => 'nullable|exists:students,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'type' => 'required|in:monthly,one_time,annual',
            // For monthly, we might want month/year. For now just generating based on structure.
        ]);

        $class = SchoolClass::findOrFail($request->school_class_id);
        
        if ($request->filled('student_id')) {
            $students = Student::where('id', $request->student_id)->where('school_class_id', $class->id)->get();
        } else {
            $students = Student::where('school_class_id', $class->id)->where('is_active', true)->get();
        }

        if ($students->isEmpty()) {
            return redirect()->back()->with('error', 'No active students found.');
        }

        // Get Fee Structures for this class based on type
        $query = FeeStructure::where('school_class_id', $class->id);

        if ($request->type == 'monthly') {
            $query->where('frequency', 1);
        } elseif ($request->type == 'annual') {
            $query->where('frequency', 3);
        } elseif ($request->type == 'one_time') {
            $query->where('frequency', 0);
        }

        // Add academic year filter if applicable
        // $query->where('academic_year', '2025-2026'); // Example

        $structures = $query->with('feeType')->get();

        if ($structures->isEmpty()) {
            return redirect()->back()->with('error', 'No fee structures found for this class and type.');
        }

        $count = 0;

        DB::transaction(function () use ($students, $structures, $request, &$count) {
            foreach ($students as $student) {
                // Create Invoice
                $invoice = FeeInvoice::create([
                    'student_id' => $student->id,
                    'invoice_no' => 'INV-' . date('Ymd') . '-' . $student->id . '-' . rand(1000, 9999),
                    'issue_date' => $request->issue_date,
                    'due_date' => $request->due_date,
                    'status' => 'unpaid',
                ]);

                $totalAmount = 0;

                foreach ($structures as $structure) {
                    $invoice->items()->create([
                        'fee_type_id' => $structure->fee_type_id,
                        'name' => $structure->feeType->name,
                        'amount' => $structure->amount,
                    ]);
                    $totalAmount += $structure->amount;
                }

                $invoice->update(['total_amount' => $totalAmount]);
                $count++;
            }
        });

        return redirect()->route('fee-invoices.index')->with('success', "$count invoices generated successfully.");
    }

    /**
     * Show form to edit invoice.
     */
    public function edit(FeeInvoice $feeInvoice)
    {
        return view('fees.invoices.edit', compact('feeInvoice'));
    }

    /**
     * Update invoice.
     */
    public function update(Request $request, FeeInvoice $feeInvoice)
    {
        $request->validate([
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'fine_amount' => 'nullable|numeric|min:0',
            'discount_amount' => 'nullable|numeric|min:0',
            'remarks' => 'nullable|string',
        ]);

        $feeInvoice->update([
            'issue_date' => $request->issue_date,
            'due_date' => $request->due_date,
            'fine_amount' => $request->fine_amount ?? 0,
            'discount_amount' => $request->discount_amount ?? 0,
            'remarks' => $request->remarks,
        ]);
        
        // Update status based on new amounts
        $totalPayable = ($feeInvoice->total_amount + $feeInvoice->fine_amount) - $feeInvoice->discount_amount;
        
        if ($feeInvoice->paid_amount >= $totalPayable) {
             $feeInvoice->status = 'paid';
        } elseif ($feeInvoice->paid_amount > 0) {
             $feeInvoice->status = 'partial';
        } else {
             $feeInvoice->status = 'unpaid';
        }
        $feeInvoice->save();

        return redirect()->route('fee-invoices.show', $feeInvoice)->with('success', 'Invoice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FeeInvoice $feeInvoice)
    {
        if ($feeInvoice->paid_amount > 0) {
             return redirect()->back()->with('error', 'Cannot delete invoice with payments.');
        }
        $feeInvoice->delete();
        return redirect()->route('fee-invoices.index')->with('success', 'Invoice deleted successfully.');
    }

    /**
     * Show invoice details.
     */
    public function show(FeeInvoice $feeInvoice)
    {
        $feeInvoice->load(['student', 'items', 'payments']);
        return view('fees.invoices.show', compact('feeInvoice'));
    }

    /**
     * Show payment form.
     */
    public function collect(FeeInvoice $feeInvoice)
    {
        return view('fees.payments.create', compact('feeInvoice'));
    }

    /**
     * Process payment.
     */
    public function pay(Request $request, FeeInvoice $feeInvoice)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:' . $feeInvoice->balance,
            'payment_date' => 'required|date',
            'payment_method' => 'required|string',
            'transaction_reference' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        DB::transaction(function () use ($request, $feeInvoice) {
            // Create Payment
            FeePayment::create([
                'fee_invoice_id' => $feeInvoice->id,
                'amount' => $request->amount,
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'transaction_reference' => $request->transaction_reference,
                'remarks' => $request->remarks,
                'collected_by' => Auth::id(),
            ]);

            // Update Invoice
            $feeInvoice->paid_amount += $request->amount;
            
            if ($feeInvoice->paid_amount >= ($feeInvoice->total_amount + $feeInvoice->fine_amount - $feeInvoice->discount_amount)) {
                $feeInvoice->status = 'paid';
            } else {
                $feeInvoice->status = 'partial';
            }
            
            $feeInvoice->save();
        });

        return redirect()->route('fee-invoices.show', $feeInvoice)->with('success', 'Payment collected successfully.');
    }

    /**
     * Print Invoice PDF.
     */
    public function print(FeeInvoice $feeInvoice)
    {
        $feeInvoice->load(['student', 'items', 'payments']);
        $pdf = Pdf::loadView('fees.invoices.pdf', compact('feeInvoice'));
        return $pdf->download('invoice_' . $feeInvoice->invoice_no . '.pdf');
    }

    /**
     * Student/Parent My Invoices.
     */
    public function myInvoices()
    {
        $user = Auth::user();
        $studentIds = [];

        if ($user->hasRole('Student')) {
            $studentIds[] = $user->studentProfile->id ?? \App\Models\Student::where('email', $user->email)->value('id');
        } elseif ($user->hasRole('Parent')) {
            $studentIds = $user->students->pluck('id')->toArray();
        }

        $invoices = FeeInvoice::whereIn('student_id', $studentIds)
            ->with(['student', 'items'])
            ->orderBy('issue_date', 'desc')
            ->get();

        return view('fees.invoices.my_invoices', compact('invoices'));
    }
}
