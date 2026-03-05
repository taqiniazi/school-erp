<?php

namespace App\Http\Controllers;

use App\Models\FeePayment;
use Illuminate\Http\Request;

class FeePaymentController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index(Request $request)
    {
        $query = FeePayment::with(['invoice.student.schoolClass', 'collectedBy']);

        if ($request->filled('start_date')) {
            $query->whereDate('payment_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('payment_date', '<=', $request->end_date);
        }

        if ($request->filled('student_id')) {
            $query->whereHas('invoice', function ($q) use ($request) {
                $q->where('student_id', $request->student_id);
            });
        }

        // Clone query for total calculation
        $totalCollected = $query->sum('amount');
        
        $payments = $query->orderBy('payment_date', 'desc')->paginate(20);
        
        return view('fees.payments.index', compact('payments', 'totalCollected'));
    }
}
