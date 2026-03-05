<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\FeePayment;
use App\Models\Attendance;
use App\Models\StaffProfile;
use App\Models\SchoolClass;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    /**
     * Academic Report: Class-wise Students List
     */
    public function academic(Request $request)
    {
        $classes = SchoolClass::all();
        $students = collect();
        
        if ($request->has('school_class_id')) {
            $query = Student::with(['schoolClass', 'section']);
            if ($request->school_class_id) {
                $query->where('school_class_id', $request->school_class_id);
            }
            if ($request->section_id) {
                $query->where('section_id', $request->section_id);
            }
            $students = $query->get();
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $pdf = Pdf::loadView('reports.academic_pdf', compact('students'));
                return $pdf->download('academic_report.pdf');
            } elseif ($request->export == 'excel') {
                return $this->exportCsv($students, ['Admission No', 'Name', 'Class', 'Section', 'Roll No', 'Gender', 'DOB'], function($student) {
                    return [
                        $student->admission_number,
                        $student->first_name . ' ' . $student->last_name,
                        $student->schoolClass->name ?? 'N/A',
                        $student->section->name ?? 'N/A',
                        $student->roll_number,
                        ucfirst($student->gender),
                        $student->dob
                    ];
                }, 'academic_report.csv');
            }
        }

        return view('reports.academic', compact('classes', 'students'));
    }

    /**
     * Financial Report: Fee Collection
     */
    public function financial(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        
        $query = FeePayment::with(['feeInvoice.student'])
            ->whereBetween('payment_date', [$startDate, $endDate]);

        $payments = $query->get();
        $totalCollection = $payments->sum('amount');

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $pdf = Pdf::loadView('reports.financial_pdf', compact('payments', 'startDate', 'endDate', 'totalCollection'));
                return $pdf->download('financial_report.pdf');
            } elseif ($request->export == 'excel') {
                 return $this->exportCsv($payments, ['Payment ID', 'Student', 'Class', 'Amount', 'Date', 'Method', 'Transaction ID'], function($payment) {
                    $student = $payment->feeInvoice->student;
                    return [
                        $payment->id,
                        $student ? $student->first_name . ' ' . $student->last_name : 'N/A',
                        $student && $student->schoolClass ? $student->schoolClass->name : 'N/A',
                        $payment->amount,
                        $payment->payment_date,
                        ucfirst($payment->payment_method),
                        $payment->transaction_id
                    ];
                }, 'financial_report.csv');
            }
        }

        return view('reports.financial', compact('payments', 'startDate', 'endDate', 'totalCollection'));
    }

    /**
     * Attendance Report: Monthly Attendance
     */
    public function attendance(Request $request)
    {
        $classes = SchoolClass::all();
        $attendances = collect();
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

        if ($request->has('school_class_id') && $request->has('section_id')) {
            // Get all students in the class/section
            $students = Student::where('school_class_id', $request->school_class_id)
                ->where('section_id', $request->section_id)
                ->orderBy('roll_number')
                ->get();

            // Get attendance records
            $attendanceRecords = Attendance::whereIn('student_id', $students->pluck('id'))
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->get()
                ->groupBy('student_id');

            // Format data for view
            foreach ($students as $student) {
                $studentAttendance = $attendanceRecords->get($student->id, collect());
                $presentCount = $studentAttendance->where('status', 'present')->count();
                $absentCount = $studentAttendance->where('status', 'absent')->count();
                $lateCount = $studentAttendance->where('status', 'late')->count();
                
                $attendances->push([
                    'student' => $student,
                    'present' => $presentCount,
                    'absent' => $absentCount,
                    'late' => $lateCount,
                    'percentage' => $daysInMonth > 0 ? round(($presentCount / $daysInMonth) * 100, 1) : 0
                ]);
            }
        }

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $pdf = Pdf::loadView('reports.attendance_pdf', compact('attendances', 'month', 'year'));
                return $pdf->download('attendance_report.pdf');
            } elseif ($request->export == 'excel') {
                return $this->exportCsv($attendances, ['Admission No', 'Name', 'Present', 'Absent', 'Late', 'Percentage'], function($record) {
                    return [
                        $record['student']->admission_number,
                        $record['student']->first_name . ' ' . $record['student']->last_name,
                        $record['present'],
                        $record['absent'],
                        $record['late'],
                        $record['percentage'] . '%'
                    ];
                }, 'attendance_report.csv');
            }
        }

        return view('reports.attendance', compact('classes', 'attendances', 'month', 'year'));
    }

    /**
     * HR Report: Staff List
     */
    public function hr(Request $request)
    {
        $staff = StaffProfile::with('user')->get();

        if ($request->has('export')) {
            if ($request->export == 'pdf') {
                $pdf = Pdf::loadView('reports.hr_pdf', compact('staff'));
                return $pdf->download('hr_report.pdf');
            } elseif ($request->export == 'excel') {
                return $this->exportCsv($staff, ['Staff ID', 'Name', 'Department', 'Designation', 'Phone', 'Email', 'Status'], function($person) {
                    return [
                        $person->id,
                        $person->first_name . ' ' . $person->last_name,
                        $person->department,
                        $person->designation,
                        $person->phone,
                        $person->email,
                        ucfirst($person->status)
                    ];
                }, 'hr_report.csv');
            }
        }

        return view('reports.hr', compact('staff'));
    }

    private function exportCsv($collection, $headers, $callback, $filename)
    {
        $headers_response = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = $headers;

        $callback_func = function() use ($collection, $columns, $callback) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach($collection as $item) {
                fputcsv($file, $callback($item));
            }
            fclose($file);
        };

        return response()->stream($callback_func, 200, $headers_response);
    }
}
