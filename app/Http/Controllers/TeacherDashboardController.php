<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Event;
use App\Models\Notice;
use App\Models\Student;
use App\Models\TeacherAllocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Cache;

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

        // Cache dashboard data for 15 minutes
        $data = Cache::remember('teacher_dashboard_' . $teacher->id, 900, function () use ($teacher) {
            // KPIs
            $totalClasses = $teacher->allocations()->distinct('school_class_id')->count('school_class_id');
            
            // Get sections assigned to teacher
            $sectionIds = $teacher->allocations()->pluck('section_id')->unique();
            
            $totalStudents = Student::whereIn('section_id', $sectionIds)->count();
            
            // Optimized query for present today using whereHas
            $presentToday = Attendance::whereHas('student', function ($query) use ($sectionIds) {
                    $query->whereIn('section_id', $sectionIds);
                })
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

            return compact(
                'totalClasses',
                'totalStudents',
                'presentToday',
                'upcomingEvents',
                'recentNotices'
            );
        });

        return view('teacher.dashboard', $data);
    }
}
