<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ParentDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDashboardController;
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
    });

    Route::middleware(['role:Student'])->group(function () {
        Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    });

    Route::middleware(['role:Parent'])->group(function () {
        Route::get('/parent/dashboard', [ParentDashboardController::class, 'index'])->name('parent.dashboard');
    });

    // Student Management (Accessible by Admin and Teacher)
    Route::middleware(['role:Super Admin|School Admin|Teacher'])->group(function () {
        Route::resource('students', StudentController::class);
        Route::get('classes/{schoolClass}/sections', [StudentController::class, 'getSections'])->name('classes.sections');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
