<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Driver;
use App\Models\Exam;
use App\Models\ExamSchedule;
use App\Models\ExamType;
use App\Models\FeeInvoice;
use App\Models\FeeInvoiceItem;
use App\Models\FeePayment;
use App\Models\FeeStructure;
use App\Models\FinancialYear;
use App\Models\Grade;
use App\Models\InventoryIssue;
use App\Models\InventoryItem;
use App\Models\InventoryPurchase;
use App\Models\InventorySupplier;
use App\Models\LessonPlan;
use App\Models\LibraryBook;
use App\Models\LibraryCategory;
use App\Models\Payslip;
use App\Models\PayslipItem;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TimetableEntry;
use App\Models\TransportRoute;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // Grades
        $grades = [
            ['grade_name' => 'A', 'min_percentage' => 85, 'max_percentage' => 100, 'remark' => 'Excellent'],
            ['grade_name' => 'B', 'min_percentage' => 70, 'max_percentage' => 84, 'remark' => 'Very Good'],
            ['grade_name' => 'C', 'min_percentage' => 60, 'max_percentage' => 69, 'remark' => 'Good'],
            ['grade_name' => 'D', 'min_percentage' => 50, 'max_percentage' => 59, 'remark' => 'Satisfactory'],
            ['grade_name' => 'F', 'min_percentage' => 0, 'max_percentage' => 49, 'remark' => 'Fail'],
        ];
        foreach ($grades as $g) {
            Grade::firstOrCreate(['grade_name' => $g['grade_name']], $g);
        }

        // Exam Types
        foreach (['Mid Term', 'Final', 'Quiz', 'Assignment', 'Practical'] as $name) {
            ExamType::firstOrCreate(['name' => $name], ['description' => $name.' assessments', 'is_active' => true]);
        }

        // Subjects and Classes
        $class = SchoolClass::orderBy('numeric_value')->first();
        $section = $class ? Section::where('school_class_id', $class->id)->orderBy('name')->first() : null;
        $subject = Subject::first();
        $teacher = Teacher::first();
        $adminUser = User::where('role', 'admin')->first() ?? User::first();
        $financialYear = FinancialYear::where('is_current', true)->first();

        // Timetable Entries (Mon-Fri, 1 period)
        if ($class && $section && $subject && $teacher) {
            for ($day = 1; $day <= 5; $day++) {
                TimetableEntry::firstOrCreate(
                    [
                        'school_class_id' => $class->id,
                        'section_id' => $section->id,
                        'subject_id' => $subject->id,
                        'teacher_id' => $teacher->id,
                        'day_of_week' => $day,
                        'start_time' => '09:00',
                        'end_time' => '09:45',
                    ],
                    [
                        'room' => 'R'.(100 + $day),
                        'note' => 'Auto-generated period',
                    ]
                );
            }
        }

        // Lesson Plans
        if ($teacher && $class && $section && $subject) {
            LessonPlan::firstOrCreate(
                [
                    'teacher_id' => $teacher->id,
                    'school_class_id' => $class->id,
                    'section_id' => $section->id,
                    'subject_id' => $subject->id,
                    'planned_date' => now()->addDays(2)->toDateString(),
                ],
                [
                    'topic' => 'Introduction to '.$subject->name,
                    'objectives' => 'Understand basics of '.$subject->name,
                    'activities' => 'Lecture, Q&A, Short Exercise',
                    'homework' => 'Read chapter 1 and summarize',
                    'resources' => 'Textbook, slides',
                    'status' => 'planned',
                ]
            );
        }

        // Exams and Schedules
        if ($class && $subject) {
            $exam = Exam::firstOrCreate(
                ['name' => 'Term 1', 'session_year' => now()->format('Y')],
                [
                    'description' => 'First term examination',
                    'start_date' => now()->addWeeks(3)->toDateString(),
                    'end_date' => now()->addWeeks(4)->toDateString(),
                    'is_published' => false,
                ]
            );
            $subjects = Subject::take(4)->get();
            foreach ($subjects as $idx => $subj) {
                ExamSchedule::firstOrCreate(
                    [
                        'exam_id' => $exam->id,
                        'school_class_id' => $class->id,
                        'subject_id' => $subj->id,
                        'exam_date' => now()->addWeeks(3)->addDays($idx)->toDateString(),
                    ],
                    [
                        'start_time' => '10:00',
                        'end_time' => '12:00',
                        'max_marks' => 100,
                        'pass_marks' => 40,
                    ]
                );
            }
        }

        // Library
        $categories = [
            ['name' => 'Fiction', 'description' => 'Fiction books'],
            ['name' => 'Science', 'description' => 'Science and research'],
            ['name' => 'History', 'description' => 'Historical records'],
        ];
        foreach ($categories as $c) {
            $cat = LibraryCategory::firstOrCreate(['name' => $c['name']], $c + ['is_active' => true]);
            // Books under category
            for ($i = 1; $i <= 2; $i++) {
                LibraryBook::firstOrCreate(
                    ['isbn' => Str::upper(Str::random(10))],
                    [
                        'title' => $c['name'].' Book '.$i,
                        'author' => 'Author '.$i,
                        'publisher' => 'Publisher '.$i,
                        'copies_total' => 5,
                        'copies_available' => 5,
                        'shelf' => 'S-'.$i,
                        'status' => 'active',
                    ]
                );
            }
        }

        // Inventory + Suppliers
        $suppliers = [
            ['name' => 'ABC Stationers', 'contact_person' => 'Mr. Ali', 'phone' => '555-1001', 'email' => 'abc@suppliers.com', 'address' => 'Market Road', 'is_active' => true],
            ['name' => 'Lab World', 'contact_person' => 'Ms. Sana', 'phone' => '555-1002', 'email' => 'lab@suppliers.com', 'address' => 'Science Street', 'is_active' => true],
        ];
        foreach ($suppliers as $s) {
            InventorySupplier::firstOrCreate(['name' => $s['name']], $s);
        }
        $items = [
            ['name' => 'Notebook', 'sku' => 'NTB-001', 'unit' => 'pcs', 'opening_stock' => 100, 'current_stock' => 100, 'reorder_level' => 20, 'status' => 'active'],
            ['name' => 'Marker', 'sku' => 'MRK-001', 'unit' => 'pcs', 'opening_stock' => 50, 'current_stock' => 50, 'reorder_level' => 10, 'status' => 'active'],
        ];
        foreach ($items as $it) {
            $item = InventoryItem::firstOrCreate(['sku' => $it['sku']], $it);
            InventoryPurchase::firstOrCreate(
                ['inventory_item_id' => $item->id, 'reference_no' => 'PO-'.$item->sku],
                ['quantity' => 50, 'unit_cost' => 2.5, 'vendor' => 'ABC Stationers', 'purchase_date' => now()->subDays(10)->toDateString(), 'created_by' => $adminUser?->id]
            );
            InventoryIssue::firstOrCreate(
                ['inventory_item_id' => $item->id, 'issue_date' => now()->subDays(5)->toDateString(), 'recipient' => 'Classroom'],
                ['quantity' => 10, 'remarks' => 'Issued for classes', 'created_by' => $adminUser?->id]
            );
        }

        // Transport
        $route = TransportRoute::firstOrCreate(
            ['name' => 'City Center Route'],
            ['start_point' => 'City Center', 'end_point' => 'School', 'fare' => 50, 'status' => 'active']
        );
        $driver = Driver::firstOrCreate(
            ['license_number' => 'LIC-'.Str::upper(Str::random(6))],
            ['name' => 'John Driver', 'phone' => '555-3000', 'status' => 'active']
        );
        Vehicle::firstOrCreate(
            ['registration_number' => 'BUS-'.rand(100, 999)],
            ['model' => 'Hino', 'capacity' => 40, 'driver_id' => $driver->id, 'transport_route_id' => $route->id, 'status' => 'active']
        );

        // Departments & Designations (optional structure)
        Department::firstOrCreate(['name' => 'Academics'], ['description' => 'Academic Department', 'is_active' => true]);
        Department::firstOrCreate(['name' => 'Administration'], ['description' => 'Admin Department', 'is_active' => true]);

        // Fees: Structures for class and invoices/payments for students
        $feeTypes = ['Admission Fee' => 5000, 'Tuition Fee' => 2000, 'Exam Fee' => 500];
        foreach ($feeTypes as $typeName => $amount) {
            $feeType = \App\Models\FeeType::where('name', $typeName)->first();
            if ($feeType && $class) {
                FeeStructure::firstOrCreate(
                    ['school_class_id' => $class->id, 'fee_type_id' => $feeType->id, 'academic_year' => now()->format('Y')],
                    ['amount' => $amount, 'frequency' => $typeName === 'Tuition Fee' ? 1 : 0]
                );
            }
        }

        $students = Student::take(3)->get();
        foreach ($students as $idx => $stu) {
            $invoice = FeeInvoice::firstOrCreate(
                ['student_id' => $stu->id, 'invoice_no' => 'INV-'.str_pad((string) ($stu->id), 6, '0', STR_PAD_LEFT)],
                [
                    'issue_date' => now()->subDays(7)->toDateString(),
                    'due_date' => now()->addDays(7)->toDateString(),
                    'total_amount' => 0,
                    'paid_amount' => 0,
                    'fine_amount' => 0,
                    'discount_amount' => 0,
                    'status' => 'unpaid',
                    'remarks' => 'Auto generated',
                ]
            );
            $total = 0;
            foreach (\App\Models\FeeType::whereIn('name', array_keys($feeTypes))->get() as $ft) {
                $amount = $feeTypes[$ft->name] ?? 0;
                FeeInvoiceItem::firstOrCreate(
                    ['fee_invoice_id' => $invoice->id, 'fee_type_id' => $ft->id, 'name' => $ft->name],
                    ['amount' => $amount]
                );
                $total += $amount;
            }
            $invoice->update(['total_amount' => $total, 'paid_amount' => $total / 2, 'status' => 'partial']);
            FeePayment::firstOrCreate(
                ['fee_invoice_id' => $invoice->id, 'amount' => $total / 2, 'payment_date' => now()->toDateString()],
                ['payment_method' => 'cash', 'transaction_reference' => 'RCPT-'.Str::upper(Str::random(6)), 'remarks' => 'Partial payment', 'collected_by' => $adminUser?->id]
            );
        }

        // Payroll: Payslip for first teacher
        if ($teacher && $financialYear) {
            $payslip = Payslip::firstOrCreate(
                ['teacher_id' => $teacher->id, 'financial_year_id' => $financialYear->id, 'payslip_no' => 'PS-'.str_pad((string) $teacher->id, 5, '0', STR_PAD_LEFT)],
                [
                    'pay_month' => now()->startOfMonth()->toDateString(),
                    'basic_salary' => 40000,
                    'total_allowances' => 5000,
                    'total_deductions' => 1000,
                    'net_salary' => 44000,
                    'generated_by' => $adminUser?->id,
                ]
            );
            PayslipItem::firstOrCreate(
                ['payslip_id' => $payslip->id, 'type' => 'allowance', 'name' => 'House Rent'],
                ['is_percentage' => false, 'value' => 0, 'amount' => 3000]
            );
            PayslipItem::firstOrCreate(
                ['payslip_id' => $payslip->id, 'type' => 'allowance', 'name' => 'Medical'],
                ['is_percentage' => false, 'value' => 0, 'amount' => 2000]
            );
            PayslipItem::firstOrCreate(
                ['payslip_id' => $payslip->id, 'type' => 'deduction', 'name' => 'Tax'],
                ['is_percentage' => false, 'value' => 0, 'amount' => 1000]
            );
        }
    }
}
