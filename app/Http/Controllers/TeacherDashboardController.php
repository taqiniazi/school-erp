<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Event;
use App\Models\Notice;
use App\Models\Student;
use App\Models\TeacherAllocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $teacher = $user->teacherProfile;
        
        // If teacher profile not found, just show empty dashboard or redirect
        if (!$teacher) {
             return view('teacher.dashboard', [
                'totalClasses' => 0,
                'totalStudents' => 0,
                'presentToday' => 0,
                'upcomingEvents' => collect(),
                'recentNotices' => collect()
             ]);
        }

        // KPIs
        $totalClasses = $teacher->allocations()->distinct('school_class_id')->count('school_class_id');
        
        // Get sections assigned to teacher
        $sectionIds = $teacher->allocations()->pluck('section_id')->unique();
        
        $totalStudents = Student::whereIn('section_id', $sectionIds)->count();
        
        $presentToday = Attendance::whereIn('student_id', Student::whereIn('section_id', $sectionIds)->pluck('id'))
            ->whereDate('date', today())
            ->where('status', 'present')
            ->count();

        // Alerts
        $upcomingEvents = Event::where('start_date', '>=', now())
            ->orderBy('start_date')
            ->take(5)
            ->get();
            
        $recentNotices = Notice::whereIn('audience_role', ['all', 'Teacher'])
            ->latest()
            ->take(5)
            ->get();

        return view('teacher.dashboard', compact(
            'totalClasses',
            'totalStudents',
            'presentToday',
            'upcomingEvents',
            'recentNotices'
        ));
    }
}
