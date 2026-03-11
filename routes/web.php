<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Billing\SubscriptionSelectionController;
use App\Http\Controllers\ParentDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeacherDashboardController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PageController;

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
            Route::get('create', [App\Http\Controllers\LeaveRequestController::class, 'create'])->name('create');
            Route::post('store', [App\Http\Controllers\LeaveRequestController::class, 'store'])->name('store');
        });
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
        Route::get('/student/report-card', [App\Http\Controllers\MarkController::class, 'myReportCard'])->name('student.report_card');
    });

    // Shared Teacher/Admin Routes
    Route::middleware(['role:Super Admin|School Admin|Teacher'])->group(function () {
        Route::get('attendance', [App\Http\Controllers\AttendanceController::class, 'index'])->name('attendance.index');
        Route::get('attendance/create', [App\Http\Controllers\AttendanceController::class, 'create'])->name('attendance.create');
        Route::post('attendance', [App\Http\Controllers\AttendanceController::class, 'store'])->name('attendance.store');
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

        Route::get('departments', function () {
            return view('admin.placeholders.module', ['title' => 'Departments']);
        })->name('departments.index');

        Route::get('designations', function () {
            return view('admin.placeholders.module', ['title' => 'Designations']);
        })->name('designations.index');

        Route::get('permissions', function () {
            return view('admin.placeholders.module', ['title' => 'Permissions']);
        })->name('permissions.index');

        Route::get('admissions', function () {
            return view('admin.placeholders.module', ['title' => 'Admissions']);
        })->name('admissions.index');

        Route::get('guardians', function () {
            return view('admin.placeholders.module', ['title' => 'Guardians']);
        })->name('guardians.index');

        Route::get('student-promotions', function () {
            return view('admin.placeholders.module', ['title' => 'Student Promotion']);
        })->name('student-promotions.index');

        Route::get('student-documents', function () {
            return view('admin.placeholders.module', ['title' => 'Student Documents']);
        })->name('student-documents.index');

        Route::get('sections', function () {
            return view('admin.placeholders.module', ['title' => 'Sections']);
        })->name('sections.index');

        Route::get('timetable', function () {
            return view('admin.placeholders.module', ['title' => 'Timetable']);
        })->name('timetable.index');

        Route::get('lesson-plans', function () {
            return view('admin.placeholders.module', ['title' => 'Lesson Plans']);
        })->name('lesson-plans.index');

        Route::get('exam-types', function () {
            return view('admin.placeholders.module', ['title' => 'Exam Types']);
        })->name('exam-types.index');

        Route::get('discounts', function () {
            return view('admin.placeholders.module', ['title' => 'Discounts']);
        })->name('discounts.index');

        Route::get('payslips', function () {
            return view('admin.placeholders.module', ['title' => 'Payslips']);
        })->name('payslips.index');

        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('general', function () {
                return view('admin.placeholders.module', ['title' => 'General Settings']);
            })->name('general');

            Route::get('email', function () {
                return view('admin.placeholders.module', ['title' => 'Email Settings']);
            })->name('email');

            Route::get('backup', function () {
                return view('admin.placeholders.module', ['title' => 'Backup']);
            })->name('backup');
        });

        // Campuses
        Route::resource('campuses', App\Http\Controllers\CampusController::class);

        // Teachers (Staff)
        Route::resource('teachers', App\Http\Controllers\TeacherController::class);
        
        // Students
        Route::resource('students', StudentController::class);

        // Teacher Allocation
        Route::get('allocations', [App\Http\Controllers\TeacherAllocationController::class, 'index'])->name('allocations.index');
        Route::post('allocations', [App\Http\Controllers\TeacherAllocationController::class, 'store'])->name('allocations.store');
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
            Route::get('suppliers', function () {
                return view('admin.placeholders.module', ['title' => 'Suppliers']);
            })->name('suppliers.index');
        });

        // Library
        Route::prefix('library')->name('library.')->group(function () {
            Route::resource('books', App\Http\Controllers\LibraryBookController::class);
            Route::resource('loans', App\Http\Controllers\LibraryLoanController::class);
            Route::post('loans/{libraryLoan}/return', [\App\Http\Controllers\LibraryLoanController::class, 'returnBook'])->name('loans.return');
            Route::get('categories', function () {
                return view('admin.placeholders.module', ['title' => 'Library Categories']);
            })->name('categories.index');
            Route::get('reports', function () {
                return view('admin.placeholders.module', ['title' => 'Library Reports']);
            })->name('reports.index');
        });

        // Examinations
        Route::resource('exams', App\Http\Controllers\ExamController::class);
        Route::get('exams/{exam}/schedules', [App\Http\Controllers\ExamController::class, 'schedules'])->name('exams.schedules');
        Route::post('exams/{exam}/schedules', [App\Http\Controllers\ExamController::class, 'storeSchedule'])->name('exams.schedules.store');
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
            Route::get('student-transport', function () {
                return view('admin.placeholders.module', ['title' => 'Student Transport']);
            })->name('student-transport.index');
        });
        Route::resource('fee-types', App\Http\Controllers\FeeTypeController::class);
        Route::resource('fee-structures', App\Http\Controllers\FeeStructureController::class);
        Route::get('fee-invoices/create', [App\Http\Controllers\FeeInvoiceController::class, 'create'])->name('fee-invoices.create');
        Route::post('fee-invoices', [App\Http\Controllers\FeeInvoiceController::class, 'store'])->name('fee-invoices.store');
        Route::get('fee-invoices/{feeInvoice}/edit', [App\Http\Controllers\FeeInvoiceController::class, 'edit'])->name('fee-invoices.edit');
        Route::put('fee-invoices/{feeInvoice}', [App\Http\Controllers\FeeInvoiceController::class, 'update'])->name('fee-invoices.update');
        Route::get('fee-invoices', [App\Http\Controllers\FeeInvoiceController::class, 'index'])->name('fee-invoices.index');
        Route::get('fee-invoices/{feeInvoice}', [App\Http\Controllers\FeeInvoiceController::class, 'show'])->name('fee-invoices.show');
        Route::post('fee-invoices/{feeInvoice}/pay', [App\Http\Controllers\FeePaymentController::class, 'store'])->name('fee-payments.store');
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
            Route::resource('messages', App\Http\Controllers\MessageController::class)->except(['edit', 'update', 'destroy']);
            Route::get('messages/sent', [App\Http\Controllers\MessageController::class, 'sent'])->name('messages.sent');
            Route::get('notifications', function () {
                return view('admin.placeholders.module', ['title' => 'Notifications']);
            })->name('notifications.index');
            Route::get('email-sms', function () {
                return view('admin.placeholders.module', ['title' => 'Email / SMS']);
            })->name('email-sms.index');
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
