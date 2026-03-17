<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Billing\SubscriptionSelectionController;
use App\Http\Controllers\ExamTypeController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\LessonPlanController;
use App\Http\Controllers\LibraryCategoryController;
use App\Http\Controllers\LibraryReportController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ParentDashboardController;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\StudentDocumentController;
use App\Http\Controllers\StudentPromotionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherDashboardController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\UiController;
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
})->name('home');

Route::get('/features', [PageController::class, 'features'])->name('pages.features');
Route::get('/pricing', [PageController::class, 'pricing'])->name('pages.pricing');
Route::get('/about', [PageController::class, 'about'])->name('pages.about');
Route::get('/contact', [PageController::class, 'contact'])->name('pages.contact');
Route::get('/blog', [PageController::class, 'blog'])->name('pages.blog');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Webhooks (Public)
Route::post('stripe/webhook', [\App\Http\Controllers\Billing\PaymentController::class, 'stripeWebhook'])->name('stripe.webhook');
Route::post('paypal/webhook', [\App\Http\Controllers\Billing\PaymentController::class, 'paypalWebhook'])->name('paypal.webhook');

Route::middleware(['auth', 'verified', 'subscribed'])->group(function () {
    Route::prefix('ui')->name('ui.')->group(function () {
        Route::get('settings', [UiController::class, 'settings'])->name('settings');
        Route::post('settings', [UiController::class, 'updateSettings'])->name('settings.update');
        Route::post('locale', [UiController::class, 'setLocale'])->name('locale');
        Route::get('notifications', [UiController::class, 'notifications'])->name('notifications');
        Route::post('notifications/mark-all-read', [UiController::class, 'markAllNotificationsRead'])->name('notifications.mark-all-read');
    });

    Route::middleware(['role:School Admin'])->prefix('billing')->name('billing.')->group(function () {
        Route::get('choose-plan', [SubscriptionSelectionController::class, 'create'])->name('choose-plan');
        Route::post('choose-plan', [SubscriptionSelectionController::class, 'store'])->name('choose-plan.store');

        // Payment Routes
        Route::get('payment/pending', [\App\Http\Controllers\Billing\PaymentController::class, 'pending'])->name('payment.pending');
        Route::get('payment/history', [\App\Http\Controllers\Billing\PaymentController::class, 'history'])->name('payment.history');
        Route::get('payment/{plan}', [\App\Http\Controllers\Billing\PaymentController::class, 'create'])->name('payment.create');
        Route::post('payment/{plan}', [\App\Http\Controllers\Billing\PaymentController::class, 'store'])->name('payment.store');

        // Online Payment Routes
        Route::post('payment/{plan}/stripe', [\App\Http\Controllers\Billing\PaymentController::class, 'payWithStripe'])->name('payment.stripe');
        Route::post('payment/{plan}/paypal', [\App\Http\Controllers\Billing\PaymentController::class, 'payWithPaypal'])->name('payment.paypal');

        // Payment Callbacks (User Redirects)
        Route::get('payment/stripe/callback', [\App\Http\Controllers\Billing\PaymentController::class, 'stripeCallback'])->name('payment.stripe.callback');
        Route::get('payment/paypal/callback', [\App\Http\Controllers\Billing\PaymentController::class, 'paypalCallback'])->name('payment.paypal.callback');
        Route::get('payment/paypal/cancel', [\App\Http\Controllers\Billing\PaymentController::class, 'paypalCancel'])->name('payment.paypal.cancel');

        // Invoice Download
        Route::get('invoice/{payment}/download', [\App\Http\Controllers\Billing\InvoiceController::class, 'download'])->name('invoice.download');
    });

    // School Admin Subscription Management
    Route::middleware(['role:School Admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('subscription', [\App\Http\Controllers\SubscriptionController::class, 'index'])->name('subscription.index');
        Route::get('subscription/upgrade', [\App\Http\Controllers\SubscriptionController::class, 'upgrade'])->name('subscription.upgrade');
    });

    Route::middleware(['role:Super Admin|School Admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/analytics', [App\Http\Controllers\AnalyticsController::class, 'index'])->name('analytics.index');
    });

    // Super Admin Payment Verification
    Route::middleware(['role:Super Admin'])->prefix('super-admin')->name('super-admin.')->group(function () {
        Route::get('dashboard', [\App\Http\Controllers\SuperAdmin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('payments', [\App\Http\Controllers\SuperAdmin\PaymentVerificationController::class, 'index'])->name('payments.index');
        Route::put('payments/{payment}', [\App\Http\Controllers\SuperAdmin\PaymentVerificationController::class, 'update'])->name('payments.update');

        Route::resource('plans', \App\Http\Controllers\SuperAdmin\PlanController::class);

        // Payment Methods Management
        Route::resource('payment-methods', \App\Http\Controllers\SuperAdmin\PaymentMethodController::class);

        Route::get('schools', [\App\Http\Controllers\SuperAdmin\SchoolController::class, 'index'])->name('schools.index');
        Route::post('schools/{school}/activate', [\App\Http\Controllers\SuperAdmin\SchoolController::class, 'activate'])->name('schools.activate');
        Route::post('schools/{school}/deactivate', [\App\Http\Controllers\SuperAdmin\SchoolController::class, 'deactivate'])->name('schools.deactivate');

        Route::resource('admin-users', \App\Http\Controllers\SuperAdmin\AdminUserController::class);

        Route::get('subscriptions', [\App\Http\Controllers\SuperAdmin\SubscriptionController::class, 'index'])->name('subscriptions.index');
        Route::post('subscriptions/{subscription}/cancel', [\App\Http\Controllers\SuperAdmin\SubscriptionController::class, 'cancel'])->name('subscriptions.cancel');
        Route::post('subscriptions/{subscription}/activate', [\App\Http\Controllers\SuperAdmin\SubscriptionController::class, 'activate'])->name('subscriptions.activate');

        Route::resource('roles', \App\Http\Controllers\SuperAdmin\RoleController::class);
    });

    Route::middleware(['role:Teacher'])->group(function () {
        Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
        Route::get('/teacher/my-attendance', [App\Http\Controllers\TeacherAttendanceController::class, 'myAttendance'])->name('teacher.my-attendance');

        // Teacher Leave Management
        Route::prefix('hr/leave')->name('hr.leave.')->group(function () {
            Route::get('my', [App\Http\Controllers\LeaveRequestController::class, 'myIndex'])->name('my');
            Route::get('request', [App\Http\Controllers\LeaveRequestController::class, 'create'])->name('request.create');
            Route::post('request', [App\Http\Controllers\LeaveRequestController::class, 'store'])->name('request.store');
        });
    });

    Route::middleware(['role:Student'])->group(function () {
        Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    });

    Route::middleware(['role:Parent'])->group(function () {
        Route::get('/parent/dashboard', [ParentDashboardController::class, 'index'])->name('parent.dashboard');

        Route::prefix('parent/leaves')->name('parent.leaves.')->group(function () {
            Route::get('/', [App\Http\Controllers\StudentLeaveRequestController::class, 'indexForParent'])->name('index');
            Route::get('create', [App\Http\Controllers\StudentLeaveRequestController::class, 'createForParent'])->name('create');
            Route::post('/', [App\Http\Controllers\StudentLeaveRequestController::class, 'storeForParent'])->name('store');
        });
    });

    // Shared Student/Parent Resources
    Route::middleware(['role:Student|Parent'])->group(function () {
        Route::get('/student/my-attendance', [StudentDashboardController::class, 'myAttendance'])->name('student.my-attendance');
        Route::get('/student/my-invoices', [StudentDashboardController::class, 'myInvoices'])->name('student.invoices');
        Route::get('/student/report-card', [App\Http\Controllers\MarkController::class, 'myReportCard'])->name('student.report_card');
    });

    // Shared Teacher/Admin Routes
    Route::middleware(['role:Super Admin|School Admin|Teacher'])->group(function () {
        Route::get('attendance', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('attendance/create', [App\Http\Controllers\AttendanceController::class, 'create'])->name('attendance.create');
        Route::get('attendance/report', [App\Http\Controllers\AttendanceController::class, 'report'])->name('attendance.report');
        Route::post('attendance', [App\Http\Controllers\AttendanceController::class, 'store'])->name('attendance.store');

        Route::prefix('student-leaves')->name('student-leaves.')->group(function () {
            Route::get('/', [App\Http\Controllers\StudentLeaveRequestController::class, 'indexForApprover'])->name('index');
            Route::post('{studentLeaveRequest}/approve', [App\Http\Controllers\StudentLeaveRequestController::class, 'approve'])->name('approve');
            Route::post('{studentLeaveRequest}/reject', [App\Http\Controllers\StudentLeaveRequestController::class, 'reject'])->name('reject');
        });
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

        Route::get('classes/{schoolClass}/sections', [SchoolClassController::class, 'getSections'])->name('classes.sections.json');
        Route::get('classes/{schoolClass}/subjects', [SchoolClassController::class, 'getSubjects'])->name('classes.subjects.json');
        Route::get('sections/{section}/students', [SchoolClassController::class, 'getStudents'])->name('sections.students.json');
        Route::get('classes/{schoolClass}/students', [SchoolClassController::class, 'getStudentsByClass'])->name('classes.students.json');

        // Subjects
        Route::resource('subjects', SubjectController::class);

        Route::resource('departments', App\Http\Controllers\DepartmentController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        Route::resource('designations', App\Http\Controllers\DesignationController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        Route::resource('permissions', App\Http\Controllers\PermissionController::class)
            ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

        Route::get('admissions', function (\Illuminate\Http\Request $request) {
            $q = trim((string) $request->get('q', ''));
            $schoolClassId = $request->get('school_class_id');
            $sectionId = $request->get('section_id');
            $status = $request->get('status');
            $from = $request->get('from');
            $to = $request->get('to');

            $query = \App\Models\Student::with(['schoolClass', 'section', 'parents'])
                ->orderByDesc('admission_date')
                ->orderByDesc('id');

            if ($q !== '') {
                $query->where(function ($w) use ($q) {
                    $w->where('admission_number', 'like', '%'.$q.'%')
                        ->orWhere('first_name', 'like', '%'.$q.'%')
                        ->orWhere('last_name', 'like', '%'.$q.'%')
                        ->orWhere('email', 'like', '%'.$q.'%')
                        ->orWhere('phone', 'like', '%'.$q.'%');
                });
            }

            if (! empty($schoolClassId)) {
                $query->where('school_class_id', $schoolClassId);
            }

            if (! empty($sectionId)) {
                $query->where('section_id', $sectionId);
            }

            if (! empty($status)) {
                $query->where('status', $status);
            }

            if (! empty($from)) {
                $query->whereDate('admission_date', '>=', $from);
            }

            if (! empty($to)) {
                $query->whereDate('admission_date', '<=', $to);
            }

            $admissions = $query->get();

            $classes = \App\Models\SchoolClass::orderBy('numeric_value')->orderBy('name')->get();
            $sections = [];
            if (! empty($schoolClassId)) {
                $sections = \App\Models\Section::where('school_class_id', $schoolClassId)->orderBy('name')->get();
            }

            $now = \Carbon\Carbon::now();
            $kpis = [
                'total_students' => \App\Models\Student::count(),
                'active_students' => \App\Models\Student::where('status', 'active')->count(),
                'admitted_today' => \App\Models\Student::whereDate('admission_date', $now->toDateString())->count(),
                'admitted_this_month' => \App\Models\Student::whereDate('admission_date', '>=', $now->copy()->startOfMonth()->toDateString())->count(),
            ];

            return view('admissions.index', compact('admissions', 'classes', 'sections', 'q', 'schoolClassId', 'sectionId', 'status', 'from', 'to', 'kpis'));
        })->name('admissions.index');

        Route::get('guardians', [GuardianController::class, 'index'])->name('guardians.index');
        Route::get('guardians/{guardian}', [GuardianController::class, 'show'])->name('guardians.show');

        Route::get('student-promotions', [StudentPromotionController::class, 'index'])->name('student-promotions.index');
        Route::post('student-promotions', [StudentPromotionController::class, 'store'])->name('student-promotions.store');

        Route::get('student-documents', [StudentDocumentController::class, 'index'])->name('student-documents.index');
        Route::post('student-documents', [StudentDocumentController::class, 'store'])->name('student-documents.store');
        Route::get('student-documents/{studentDocument}/download', [StudentDocumentController::class, 'download'])->name('student-documents.download');
        Route::delete('student-documents/{studentDocument}', [StudentDocumentController::class, 'destroy'])->name('student-documents.destroy');

        Route::get('sections', [SectionController::class, 'index'])->name('sections.index');
        Route::post('sections/manage', [SectionController::class, 'store'])->name('sections.manage.store');
        Route::put('sections/manage/{section}', [SectionController::class, 'update'])->name('sections.manage.update');
        Route::delete('sections/manage/{section}', [SectionController::class, 'destroy'])->name('sections.manage.destroy');

        Route::get('timetable', [TimetableController::class, 'index'])->name('timetable.index');
        Route::get('timetable/create', [TimetableController::class, 'create'])->name('timetable.create');
        Route::post('timetable', [TimetableController::class, 'store'])->name('timetable.store');
        Route::get('timetable/{entry}/edit', [TimetableController::class, 'edit'])->name('timetable.edit');
        Route::put('timetable/{entry}', [TimetableController::class, 'update'])->name('timetable.update');
        Route::delete('timetable/{entry}', [TimetableController::class, 'destroy'])->name('timetable.destroy');

        Route::get('lesson-plans', [LessonPlanController::class, 'index'])->name('lesson-plans.index');
        Route::get('lesson-plans/create', [LessonPlanController::class, 'create'])->name('lesson-plans.create');
        Route::post('lesson-plans', [LessonPlanController::class, 'store'])->name('lesson-plans.store');
        Route::get('lesson-plans/{lessonPlan}/edit', [LessonPlanController::class, 'edit'])->name('lesson-plans.edit');
        Route::put('lesson-plans/{lessonPlan}', [LessonPlanController::class, 'update'])->name('lesson-plans.update');
        Route::delete('lesson-plans/{lessonPlan}', [LessonPlanController::class, 'destroy'])->name('lesson-plans.destroy');

        Route::resource('exam-types', ExamTypeController::class)->except(['show']);

        Route::resource('discounts', \App\Http\Controllers\DiscountController::class)->except(['show']);

        Route::get('payslips', [PayslipController::class, 'index'])->name('payslips.index');
        Route::get('payslips/create', [PayslipController::class, 'create'])->name('payslips.create');
        Route::post('payslips', [PayslipController::class, 'store'])->name('payslips.store');
        Route::get('payslips/{payslip}', [PayslipController::class, 'show'])->name('payslips.show');
        Route::get('payslips/{payslip}/print', [PayslipController::class, 'print'])->name('payslips.print');
        Route::delete('payslips/{payslip}', [PayslipController::class, 'destroy'])->name('payslips.destroy');

        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('general', [\App\Http\Controllers\SettingsController::class, 'general'])->name('general');
            Route::post('general', [\App\Http\Controllers\SettingsController::class, 'updateGeneral'])->name('general.update');

            Route::get('email', [\App\Http\Controllers\SettingsController::class, 'email'])->name('email');
            Route::post('email', [\App\Http\Controllers\SettingsController::class, 'updateEmail'])->name('email.update');
            Route::post('email/test', [\App\Http\Controllers\SettingsController::class, 'sendTestEmail'])->name('email.test');

            Route::get('backup', [\App\Http\Controllers\SettingsController::class, 'backup'])->name('backup');
            Route::post('backup', [\App\Http\Controllers\SettingsController::class, 'createBackup'])->name('backup.create');
            Route::get('backup/{backupFile}', [\App\Http\Controllers\SettingsController::class, 'downloadBackup'])->name('backup.download');
            Route::delete('backup/{backupFile}', [\App\Http\Controllers\SettingsController::class, 'deleteBackup'])->name('backup.delete');
        });

        // Campuses
        Route::resource('campuses', App\Http\Controllers\CampusController::class);

        // Teachers (Staff)
        Route::resource('teachers', App\Http\Controllers\TeacherController::class);

        Route::post('teachers/{teacher}/allocations', [App\Http\Controllers\TeacherController::class, 'storeAllocation'])->name('teachers.allocations.store');
        Route::delete('teachers/allocations/{allocation}', [App\Http\Controllers\TeacherController::class, 'destroyAllocation'])->name('teachers.allocations.destroy');

        // Students
        Route::resource('students', StudentController::class);

        // Teacher Allocation
        Route::get('allocations', [App\Http\Controllers\TeacherAllocationController::class, 'index'])->name('allocations.index');
        Route::post('allocations', [App\Http\Controllers\TeacherAllocationController::class, 'store'])->name('allocations.store');
        Route::put('allocations/{allocation}', [App\Http\Controllers\TeacherAllocationController::class, 'update'])->name('allocations.update');
        Route::delete('allocations/{allocation}', [App\Http\Controllers\TeacherAllocationController::class, 'destroy'])->name('allocations.destroy');

        // Teacher Attendance
        Route::get('teacher-attendance', [App\Http\Controllers\TeacherAttendanceController::class, 'index'])->name('teacher-attendance.index');
        Route::get('teacher-attendance/create', [App\Http\Controllers\TeacherAttendanceController::class, 'create'])->name('teacher-attendance.create');
        Route::post('teacher-attendance', [App\Http\Controllers\TeacherAttendanceController::class, 'store'])->name('teacher-attendance.store');
        Route::get('teacher-attendance/report', [App\Http\Controllers\TeacherAttendanceController::class, 'report'])->name('teacher-attendance.report');

        // Inventory
        Route::prefix('inventory')->name('inventory.')->group(function () {
            Route::resource('items', App\Http\Controllers\InventoryItemController::class);
            Route::resource('purchases', App\Http\Controllers\InventoryPurchaseController::class);
            Route::resource('issues', App\Http\Controllers\InventoryIssueController::class);
            Route::resource('returns', App\Http\Controllers\InventoryReturnController::class);
            Route::get('alerts/low-stock', [App\Http\Controllers\InventoryAlertController::class, 'lowStock'])->name('alerts.low_stock');
            Route::resource('suppliers', App\Http\Controllers\InventorySupplierController::class)->except(['show']);
        });

        // Library
        Route::prefix('library')->name('library.')->group(function () {
            Route::resource('books', App\Http\Controllers\LibraryBookController::class);
            Route::resource('loans', App\Http\Controllers\LibraryLoanController::class);
            Route::post('loans/{libraryLoan}/return', [\App\Http\Controllers\LibraryLoanController::class, 'returnBook'])->name('loans.return');
            Route::resource('categories', LibraryCategoryController::class)->except(['show']);
            Route::get('reports', [LibraryReportController::class, 'index'])->name('reports.index');
        });

        // Examinations
        Route::resource('exams', App\Http\Controllers\ExamController::class);
        Route::get('exams/{exam}/schedules', [App\Http\Controllers\ExamController::class, 'schedules'])->name('exams.schedules');
        Route::post('exams/{exam}/schedules', [App\Http\Controllers\ExamController::class, 'storeSchedule'])->name('exams.schedules.store');
        Route::delete('exams/schedules/{schedule}', [App\Http\Controllers\ExamController::class, 'deleteSchedule'])->name('exams.schedules.destroy');
        Route::resource('grades', App\Http\Controllers\GradeController::class);

        // Marks
        Route::get('marks', [App\Http\Controllers\MarkController::class, 'index'])->name('marks.index');
        Route::get('marks/create', [App\Http\Controllers\MarkController::class, 'create'])->name('marks.create');
        Route::post('marks', [App\Http\Controllers\MarkController::class, 'store'])->name('marks.store');
        Route::get('report-cards', [App\Http\Controllers\MarkController::class, 'reportCard'])->name('marks.report_card');
        Route::get('report-cards/generate', [App\Http\Controllers\MarkController::class, 'generateReportCard'])->name('marks.generate_report_card');

        // Fee Management
        Route::resource('financial-years', App\Http\Controllers\FinancialYearController::class);
        Route::prefix('accounting')->name('accounting.')->group(function () {
            Route::resource('income', App\Http\Controllers\IncomeController::class);
            Route::resource('expense', App\Http\Controllers\ExpenseController::class);
            Route::get('reports/profit-loss', [App\Http\Controllers\AccountingReportController::class, 'profitLoss'])->name('reports.profit_loss');
        });
        Route::prefix('payroll')->name('payroll.')->group(function () {
            Route::resource('salaries', App\Http\Controllers\PayrollController::class);
        });
        Route::prefix('transport')->name('transport.')->group(function () {
            Route::resource('vehicles', App\Http\Controllers\VehicleController::class);
            Route::resource('routes', App\Http\Controllers\TransportRouteController::class);
            Route::resource('drivers', App\Http\Controllers\DriverController::class);
            Route::get('student-transport', [App\Http\Controllers\StudentTransportController::class, 'index'])->name('student-transport.index');
            Route::get('student-transport/create', [App\Http\Controllers\StudentTransportController::class, 'create'])->name('student-transport.create');
            Route::post('student-transport', [App\Http\Controllers\StudentTransportController::class, 'store'])->name('student-transport.store');
            Route::delete('student-transport/{studentTransport}', [App\Http\Controllers\StudentTransportController::class, 'destroy'])->name('student-transport.destroy');
        });
        Route::resource('fee-types', App\Http\Controllers\FeeTypeController::class);
        Route::resource('fee-structures', App\Http\Controllers\FeeStructureController::class);
        Route::get('fee-invoices/create', [App\Http\Controllers\FeeInvoiceController::class, 'create'])->name('fee-invoices.create');
        Route::post('fee-invoices', [App\Http\Controllers\FeeInvoiceController::class, 'store'])->name('fee-invoices.store');
        Route::get('fee-invoices/{feeInvoice}/edit', [App\Http\Controllers\FeeInvoiceController::class, 'edit'])->name('fee-invoices.edit');
        Route::put('fee-invoices/{feeInvoice}', [App\Http\Controllers\FeeInvoiceController::class, 'update'])->name('fee-invoices.update');
        Route::get('fee-invoices', [App\Http\Controllers\FeeInvoiceController::class, 'index'])->name('fee-invoices.index');
        Route::get('fee-invoices/{feeInvoice}', [App\Http\Controllers\FeeInvoiceController::class, 'show'])->name('fee-invoices.show');
        Route::delete('fee-invoices/{feeInvoice}', [App\Http\Controllers\FeeInvoiceController::class, 'destroy'])->name('fee-invoices.destroy');
        Route::get('fee-invoices/{feeInvoice}/collect', [App\Http\Controllers\FeeInvoiceController::class, 'collect'])->name('fee-invoices.collect');
        Route::post('fee-invoices/{feeInvoice}/pay', [App\Http\Controllers\FeeInvoiceController::class, 'pay'])->name('fee-invoices.pay');
        Route::get('fee-invoices/{feeInvoice}/print', [App\Http\Controllers\FeeInvoiceController::class, 'print'])->name('fee-invoices.print');

        Route::get('fee-payments', [App\Http\Controllers\FeePaymentController::class, 'index'])->name('fee-payments.index');
        Route::get('fee-payments/history', [App\Http\Controllers\FeePaymentController::class, 'history'])->name('fee-payments.history');

        // Reports
        Route::prefix('reports')->name('reports.')->group(function () {
            Route::get('/', [App\Http\Controllers\ReportController::class, 'index'])->name('index');
            Route::get('/academic', [App\Http\Controllers\ReportController::class, 'academic'])->name('academic');
            Route::get('/financial', [App\Http\Controllers\ReportController::class, 'financial'])->name('financial');
            Route::get('/attendance', [App\Http\Controllers\ReportController::class, 'attendance'])->name('attendance');
            Route::get('/hr', [App\Http\Controllers\ReportController::class, 'hr'])->name('hr');
        });

        // Audit Logs
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('audit-logs', [App\Http\Controllers\AuditLogController::class, 'index'])->name('audit-logs.index');
            Route::get('audit-logs/{auditLog}', [App\Http\Controllers\AuditLogController::class, 'show'])->name('audit-logs.show');
        });

        // HR
        Route::prefix('hr')->name('hr.')->group(function () {
            Route::resource('staff', App\Http\Controllers\StaffProfileController::class);

            // Leave Management (Admin)
            Route::post('leave/{leaveRequest}/approve', [App\Http\Controllers\LeaveRequestController::class, 'approve'])->name('leave.approve');
            Route::post('leave/{leaveRequest}/reject', [App\Http\Controllers\LeaveRequestController::class, 'reject'])->name('leave.reject');
            Route::resource('leave', App\Http\Controllers\LeaveRequestController::class);
        });

        // Communication
        Route::prefix('communication')->name('communication.')->group(function () {
            Route::resource('notices', App\Http\Controllers\NoticeController::class);
            Route::resource('events', App\Http\Controllers\EventController::class);
            Route::get('messages/sent', [App\Http\Controllers\MessageController::class, 'sent'])->name('messages.sent');
            Route::resource('messages', App\Http\Controllers\MessageController::class)->except(['edit', 'update']);
            Route::get('notifications', function () {
                $user = auth()->user();
                $notifications = $user->notifications()->latest()->get();
                $unreadCount = $user->unreadNotifications()->count();

                return view('communication.notifications.index', compact('notifications', 'unreadCount'));
            })->name('notifications.index');
            Route::get('email-sms', [App\Http\Controllers\EmailSmsController::class, 'index'])->name('email-sms.index');
            Route::get('email-sms/create', [App\Http\Controllers\EmailSmsController::class, 'create'])->name('email-sms.create');
            Route::post('email-sms', [App\Http\Controllers\EmailSmsController::class, 'store'])->name('email-sms.store');
            Route::get('email-sms/{emailSmsLog}', [App\Http\Controllers\EmailSmsController::class, 'show'])->name('email-sms.show');
        });
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('library/my', [App\Http\Controllers\MyLibraryController::class, 'index'])->name('library.my');
    });
});

require __DIR__.'/auth.php';
