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
        Route::get('fee-invoices/{feeInvoice}/edit', [App\Http\Controllers\FeeInvoiceController::class, 'edit'])->name('fee-invoices.edit');
        Route::put('fee-invoices/{feeInvoice}', [App\Http\Controllers\FeeInvoiceController::class, 'update'])->name('fee-invoices.update');
        Route::delete('fee-invoices/{feeInvoice}', [App\Http\Controllers\FeeInvoiceController::class, 'destroy'])->name('fee-invoices.destroy');

        // Accounting: Financial Years
        Route::resource('financial-years', App\Http\Controllers\FinancialYearController::class)->parameters([
            'financial-years' => 'financialYear'
        ]);
        Route::post('financial-years/{financialYear}/set-current', [App\Http\Controllers\FinancialYearController::class, 'setCurrent'])->name('financial-years.set-current');

        // Accounting: Income
        Route::get('accounting/income', [App\Http\Controllers\IncomeController::class, 'index'])->name('accounting.income.index');
        Route::get('accounting/income/create', [App\Http\Controllers\IncomeController::class, 'create'])->name('accounting.income.create');
        Route::post('accounting/income', [App\Http\Controllers\IncomeController::class, 'store'])->name('accounting.income.store');
        Route::get('accounting/income/{income}/edit', [App\Http\Controllers\IncomeController::class, 'edit'])->name('accounting.income.edit');
        Route::put('accounting/income/{income}', [App\Http\Controllers\IncomeController::class, 'update'])->name('accounting.income.update');
        Route::delete('accounting/income/{income}', [App\Http\Controllers\IncomeController::class, 'destroy'])->name('accounting.income.destroy');

        // Accounting: Expenses
        Route::get('accounting/expense', [App\Http\Controllers\ExpenseController::class, 'index'])->name('accounting.expense.index');
        Route::get('accounting/expense/create', [App\Http\Controllers\ExpenseController::class, 'create'])->name('accounting.expense.create');
        Route::post('accounting/expense', [App\Http\Controllers\ExpenseController::class, 'store'])->name('accounting.expense.store');
        Route::get('accounting/expense/{expense}/edit', [App\Http\Controllers\ExpenseController::class, 'edit'])->name('accounting.expense.edit');
        Route::put('accounting/expense/{expense}', [App\Http\Controllers\ExpenseController::class, 'update'])->name('accounting.expense.update');
        Route::delete('accounting/expense/{expense}', [App\Http\Controllers\ExpenseController::class, 'destroy'])->name('accounting.expense.destroy');

        // Accounting: Reports
        Route::get('accounting/reports/profit-loss', [App\Http\Controllers\AccountingReportController::class, 'profitLoss'])->name('accounting.reports.profit_loss');
    });

    // Fee Collection (Admin & Teacher)
    Route::middleware(['role:Super Admin|School Admin|Teacher'])->group(function () {
        Route::get('fee-invoices', [App\Http\Controllers\FeeInvoiceController::class, 'index'])->name('fee-invoices.index');
        Route::get('fee-invoices/{feeInvoice}/collect', [App\Http\Controllers\FeeInvoiceController::class, 'collect'])->name('fee-invoices.collect');
        Route::post('fee-invoices/{feeInvoice}/pay', [App\Http\Controllers\FeeInvoiceController::class, 'pay'])->name('fee-invoices.pay');
        Route::get('fee-payments', [App\Http\Controllers\FeePaymentController::class, 'index'])->name('fee-payments.index');
    });

    // Fee Invoices (Shared Access)
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('fee-invoices/{feeInvoice}', [App\Http\Controllers\FeeInvoiceController::class, 'show'])->name('fee-invoices.show');
        Route::get('fee-invoices/{feeInvoice}/print', [App\Http\Controllers\FeeInvoiceController::class, 'print'])->name('fee-invoices.print');
    });

    // Student/Parent View Fees
    Route::middleware(['role:Student|Parent'])->group(function () {
         Route::get('my-invoices', [App\Http\Controllers\FeeInvoiceController::class, 'myInvoices'])->name('student.invoices');
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
