<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        return view('student.dashboard');
    }

    /**
     * Show student's own attendance.
     */
    public function myAttendance(Request $request)
    {
        $user = Auth::user();
        $student = null;
        $children = collect();

        if ($user->hasRole('Student')) {
            // The relationship in User model is 'studentProfile'
            $student = $user->studentProfile; 
            
            if (!$student) {
                // Fallback: Try to find by email if relationship not set up or user_id is null
                 $student = \App\Models\Student::where('email', $user->email)->first();
            }
        } elseif ($user->hasRole('Parent')) {
            $children = $user->students;
            
            if ($children->isEmpty()) {
                return redirect()->back()->with('error', 'No students linked to your account.');
            }
            
            if ($request->has('student_id')) {
                $student = $children->where('id', $request->student_id)->first();
                if (!$student) {
                    return redirect()->back()->with('error', 'Invalid student selected.');
                }
            } else {
                $student = $children->first();
            }
        }

        if (!$student) {
            return redirect()->back()->with('error', 'Student record not found.');
        }

        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        
        $attendances = Attendance::where('student_id', $student->id)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->get()
            ->keyBy(function($item) {
                return $item->date->format('Y-m-d');
            });

        return view('student.my_attendance', compact('student', 'attendances', 'month', 'year', 'daysInMonth', 'children'));
    }
}
