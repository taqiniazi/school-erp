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
    });

    Route::middleware(['role:Parent'])->group(function () {
        Route::get('/parent/dashboard', [ParentDashboardController::class, 'index'])->name('parent.dashboard');
    });

    // Shared Student/Parent Resources
    Route::middleware(['role:Student|Parent'])->group(function () {
        Route::get('/student/my-attendance', [StudentDashboardController::class, 'myAttendance'])->name('student.my-attendance');
        Route::get('/student/my-invoices', [StudentDashboardController::class, 'myInvoices'])->name('student.invoices');
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
        Route::get('classes/{schoolClass}/students', [SchoolClassController::class, 'getStudentsByClass'])->name('classes.students');
        Route::get('sections/{section}/students', [SchoolClassController::class, 'getStudents'])->name('sections.students');

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

        // HR: Staff Profiles
        Route::get('hr/staff', [\App\Http\Controllers\StaffProfileController::class, 'index'])->name('hr.staff.index');
        Route::get('hr/staff/create', [\App\Http\Controllers\StaffProfileController::class, 'create'])->name('hr.staff.create');
        Route::post('hr/staff', [\App\Http\Controllers\StaffProfileController::class, 'store'])->name('hr.staff.store');
        Route::get('hr/staff/{staffProfile}/edit', [\App\Http\Controllers\StaffProfileController::class, 'edit'])->name('hr.staff.edit');
        Route::put('hr/staff/{staffProfile}', [\App\Http\Controllers\StaffProfileController::class, 'update'])->name('hr.staff.update');
        Route::delete('hr/staff/{staffProfile}', [\App\Http\Controllers\StaffProfileController::class, 'destroy'])->name('hr.staff.destroy');

        // HR: Leave Management Approval
        Route::get('hr/leave', [\App\Http\Controllers\LeaveRequestController::class, 'index'])->name('hr.leave.index');
        Route::post('hr/leave/{leaveRequest}/approve', [\App\Http\Controllers\LeaveRequestController::class, 'approve'])->name('hr.leave.approve');
        Route::post('hr/leave/{leaveRequest}/reject', [\App\Http\Controllers\LeaveRequestController::class, 'reject'])->name('hr.leave.reject');

        // HR: Performance Reviews
        Route::get('hr/performance', [\App\Http\Controllers\PerformanceReviewController::class, 'index'])->name('hr.performance.index');
        Route::get('hr/performance/create', [\App\Http\Controllers\PerformanceReviewController::class, 'create'])->name('hr.performance.create');
        Route::post('hr/performance', [\App\Http\Controllers\PerformanceReviewController::class, 'store'])->name('hr.performance.store');
        Route::get('hr/performance/{performanceReview}/edit', [\App\Http\Controllers\PerformanceReviewController::class, 'edit'])->name('hr.performance.edit');
        Route::put('hr/performance/{performanceReview}', [\App\Http\Controllers\PerformanceReviewController::class, 'update'])->name('hr.performance.update');
        Route::delete('hr/performance/{performanceReview}', [\App\Http\Controllers\PerformanceReviewController::class, 'destroy'])->name('hr.performance.destroy');

        // Inventory Management
        Route::get('inventory/items', [\App\Http\Controllers\InventoryItemController::class, 'index'])->name('inventory.items.index');
        Route::get('inventory/items/create', [\App\Http\Controllers\InventoryItemController::class, 'create'])->name('inventory.items.create');
        Route::post('inventory/items', [\App\Http\Controllers\InventoryItemController::class, 'store'])->name('inventory.items.store');
        Route::get('inventory/items/{inventoryItem}/edit', [\App\Http\Controllers\InventoryItemController::class, 'edit'])->name('inventory.items.edit');
        Route::put('inventory/items/{inventoryItem}', [\App\Http\Controllers\InventoryItemController::class, 'update'])->name('inventory.items.update');
        Route::delete('inventory/items/{inventoryItem}', [\App\Http\Controllers\InventoryItemController::class, 'destroy'])->name('inventory.items.destroy');

        Route::get('inventory/purchases', [\App\Http\Controllers\InventoryPurchaseController::class, 'index'])->name('inventory.purchases.index');
        Route::get('inventory/purchases/create', [\App\Http\Controllers\InventoryPurchaseController::class, 'create'])->name('inventory.purchases.create');
        Route::post('inventory/purchases', [\App\Http\Controllers\InventoryPurchaseController::class, 'store'])->name('inventory.purchases.store');

        Route::get('inventory/issues', [\App\Http\Controllers\InventoryIssueController::class, 'index'])->name('inventory.issues.index');
        Route::get('inventory/issues/create', [\App\Http\Controllers\InventoryIssueController::class, 'create'])->name('inventory.issues.create');
        Route::post('inventory/issues', [\App\Http\Controllers\InventoryIssueController::class, 'store'])->name('inventory.issues.store');

        Route::get('inventory/returns', [\App\Http\Controllers\InventoryReturnController::class, 'index'])->name('inventory.returns.index');
        Route::get('inventory/returns/create', [\App\Http\Controllers\InventoryReturnController::class, 'create'])->name('inventory.returns.create');
        Route::post('inventory/returns', [\App\Http\Controllers\InventoryReturnController::class, 'store'])->name('inventory.returns.store');

        Route::get('inventory/alerts/low-stock', [\App\Http\Controllers\InventoryAlertController::class, 'lowStock'])->name('inventory.alerts.low_stock');
    });

    // Examination Management (Admin)
    Route::middleware(['role:Super Admin|School Admin'])->group(function () {
        Route::resource('exams', App\Http\Controllers\ExamController::class);
        Route::get('exams/{exam}/schedules', [App\Http\Controllers\ExamController::class, 'schedules'])->name('exams.schedules');
        Route::post('exams/{exam}/schedules', [App\Http\Controllers\ExamController::class, 'storeSchedule'])->name('exams.schedules.store');
        Route::delete('exams/schedules/{schedule}', [App\Http\Controllers\ExamController::class, 'deleteSchedule'])->name('exams.schedules.destroy');
        Route::post('exams/{exam}/publish', [App\Http\Controllers\ExamController::class, 'publish'])->name('exams.publish');
        Route::post('exams/{exam}/unpublish', [App\Http\Controllers\ExamController::class, 'unpublish'])->name('exams.unpublish');
        
        Route::resource('grades', App\Http\Controllers\GradeController::class);
    });

    // Library Management (Admin)
    Route::middleware(['role:Super Admin|School Admin'])->group(function () {
        Route::get('library/books', [\App\Http\Controllers\LibraryBookController::class, 'index'])->name('library.books.index');
        Route::get('library/books/create', [\App\Http\Controllers\LibraryBookController::class, 'create'])->name('library.books.create');
        Route::post('library/books', [\App\Http\Controllers\LibraryBookController::class, 'store'])->name('library.books.store');
        Route::get('library/books/{libraryBook}/edit', [\App\Http\Controllers\LibraryBookController::class, 'edit'])->name('library.books.edit');
        Route::put('library/books/{libraryBook}', [\App\Http\Controllers\LibraryBookController::class, 'update'])->name('library.books.update');
        Route::delete('library/books/{libraryBook}', [\App\Http\Controllers\LibraryBookController::class, 'destroy'])->name('library.books.destroy');

        Route::get('library/loans', [\App\Http\Controllers\LibraryLoanController::class, 'index'])->name('library.loans.index');
        Route::get('library/loans/create', [\App\Http\Controllers\LibraryLoanController::class, 'create'])->name('library.loans.create');
        Route::post('library/loans', [\App\Http\Controllers\LibraryLoanController::class, 'store'])->name('library.loans.store');
        Route::post('library/loans/{libraryLoan}/return', [\App\Http\Controllers\LibraryLoanController::class, 'returnBook'])->name('library.loans.return');
    });

    // My Library (Student & Teacher)
    Route::middleware(['role:Student|Teacher'])->group(function () {
        Route::get('my-library', [\App\Http\Controllers\MyLibraryController::class, 'index'])->name('library.my');
    });

    // Marks Management (Admin & Teacher)
    Route::middleware(['role:Super Admin|School Admin|Teacher'])->group(function () {
        Route::get('marks', [App\Http\Controllers\MarkController::class, 'index'])->name('marks.index');
        Route::get('marks/create', [App\Http\Controllers\MarkController::class, 'create'])->name('marks.create');
        Route::post('marks', [App\Http\Controllers\MarkController::class, 'store'])->name('marks.store');
        
        // Report Cards (Admin & Teacher View)
        Route::get('report-cards', [App\Http\Controllers\MarkController::class, 'reportCard'])->name('marks.report_card');
        Route::get('report-cards/generate', [App\Http\Controllers\MarkController::class, 'generateReportCard'])->name('marks.generate_report_card');
    });

    // Student/Parent View Report Cards
    Route::middleware(['role:Student|Parent'])->group(function () {
         Route::get('my-report-card', [App\Http\Controllers\MarkController::class, 'myReportCard'])->name('student.report_card');
    });

    // Fee Management (Admin)
    Route::middleware(['role:Super Admin|School Admin'])->group(function () {
        Route::resource('fee-types', App\Http\Controllers\FeeTypeController::class);
        Route::resource('fee-structures', App\Http\Controllers\FeeStructureController::class);
        
        // Fee Invoices (Admin Only for Generation)
        Route::get('fee-invoices/create', [App\Http\Controllers\FeeInvoiceController::class, 'create'])->name('fee-invoices.create');
        Route::post('fee-invoices', [App\Http\Controllers\FeeInvoiceController::class, 'store'])->name('fee-invoices.store');
        
        // Adjustments (Admin Only)
        Route::get('fee-invoices/{feeInvoice}/edit', [App\Http\Controllers\FeeInvoiceController::class, 'edit'])->name('fee-invoices.edit');
        Route::put('fee-invoices/{feeInvoice}', [App\Http\Controllers\FeeInvoiceController::class, 'update'])->name('fee-invoices.update');

        Route::get('fee-invoices', [App\Http\Controllers\FeeInvoiceController::class, 'index'])->name('fee-invoices.index');
        Route::get('fee-invoices/{feeInvoice}', [App\Http\Controllers\FeeInvoiceController::class, 'show'])->name('fee-invoices.show');
        
        // Payments (Admin)
        Route::post('fee-invoices/{feeInvoice}/pay', [App\Http\Controllers\FeePaymentController::class, 'store'])->name('fee-payments.store');
        Route::get('fee-payments/history', [App\Http\Controllers\FeePaymentController::class, 'history'])->name('fee-payments.history');
    });

    // Student Fee View
    Route::middleware(['role:Student|Parent'])->group(function () {
        Route::get('my-invoices', [App\Http\Controllers\FeeInvoiceController::class, 'myInvoices'])->name('student.invoices');
        Route::get('my-invoices/{feeInvoice}/pdf', [App\Http\Controllers\FeeInvoiceController::class, 'downloadPdf'])->name('student.invoices.pdf');
    });

    // Communication Module
    Route::prefix('communication')->name('communication.')->group(function () {
        // Notices
        Route::resource('notices', App\Http\Controllers\NoticeController::class);
        
        // Events
        Route::resource('events', App\Http\Controllers\EventController::class);
        
        // Messages
        Route::get('messages/sent', [App\Http\Controllers\MessageController::class, 'sent'])->name('messages.sent');
        Route::resource('messages', App\Http\Controllers\MessageController::class);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
