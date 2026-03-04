<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ParentDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::middleware(['role:Super Admin|School Admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    });

    Route::middleware(['role:Teacher'])->group(function () {
        Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
        Route::get('/teacher/my-attendance', [App\Http\Controllers\TeacherAttendanceController::class, 'myAttendance'])->name('teacher.my-attendance');
    });

    Route::middleware(['role:Student'])->group(function () {
        Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
        Route::get('/student/my-attendance', [StudentDashboardController::class, 'myAttendance'])->name('student.my-attendance');
    });

    Route::middleware(['role:Parent'])->group(function () {
        Route::get('/parent/dashboard', [ParentDashboardController::class, 'index'])->name('parent.dashboard');
    });

    // Academic Management (Accessible by Admin)
    Route::middleware(['role:Super Admin|School Admin'])->group(function () {
        // Classes & Sections
        Route::resource('classes', SchoolClassController::class)->parameters(['classes' => 'schoolClass']);
        Route::post('classes/{schoolClass}/sections', [SchoolClassController::class, 'storeSection'])->name('classes.sections.store');
        Route::delete('sections/{section}', [SchoolClassController::class, 'destroySection'])->name('sections.destroy');
        
        // Class-Subject Mapping
        Route::post('classes/{schoolClass}/subjects', [SchoolClassController::class, 'storeSubject'])->name('classes.subjects.store');
        Route::delete('classes/{schoolClass}/subjects/{subject}', [SchoolClassController::class, 'destroySubject'])->name('classes.subjects.destroy');
        
        // Subjects
        Route::resource('subjects', SubjectController::class);
    });

    // Shared Resources (Accessible by Admin and Teacher)
    Route::middleware(['role:Super Admin|School Admin|Teacher'])->group(function () {
        // JSON Data for Dynamic Forms
        Route::get('classes/{schoolClass}/sections', [SchoolClassController::class, 'getSections'])->name('classes.sections');
        Route::get('classes/{schoolClass}/subjects', [SchoolClassController::class, 'getSubjects'])->name('classes.subjects');

        // Student Attendance Management
        Route::get('attendance', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('attendance/report', [App\Http\Controllers\AttendanceController::class, 'report'])->name('attendance.report'); // Report must be before create to avoid conflict with {param} if any
        Route::get('attendance/create', [App\Http\Controllers\AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('attendance', [App\Http\Controllers\AttendanceController::class, 'store'])->name('attendance.store');
    });

    // Teacher Attendance Management (Accessible by Admin)
    Route::middleware(['role:Super Admin|School Admin'])->group(function () {
        Route::get('teacher-attendance', [App\Http\Controllers\TeacherAttendanceController::class, 'index'])->name('teacher-attendance.index');
        Route::get('teacher-attendance/report', [App\Http\Controllers\TeacherAttendanceController::class, 'report'])->name('teacher-attendance.report');
        Route::get('teacher-attendance/create', [App\Http\Controllers\TeacherAttendanceController::class, 'create'])->name('teacher-attendance.create');
        Route::post('teacher-attendance', [App\Http\Controllers\TeacherAttendanceController::class, 'store'])->name('teacher-attendance.store');
    });

    // Student Management (Accessible by Admin and Teacher)
    Route::middleware(['role:Super Admin|School Admin|Teacher'])->group(function () {
        Route::resource('students', StudentController::class);
    });

    // Teacher Management (Accessible by Admin)
    Route::middleware(['role:Super Admin|School Admin'])->group(function () {
        Route::resource('teachers', \App\Http\Controllers\TeacherController::class);
        Route::post('teachers/{teacher}/allocations', [\App\Http\Controllers\TeacherController::class, 'storeAllocation'])->name('teachers.allocations.store');
        Route::delete('allocations/{allocation}', [\App\Http\Controllers\TeacherController::class, 'destroyAllocation'])->name('teachers.allocations.destroy');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
