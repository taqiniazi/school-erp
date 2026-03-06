<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSchoolIdToTables extends Migration
{
    public function up(): void
    {
        $tables = [
            'users',
            'students',
            'teachers',
            'school_classes',
            'sections',
            'subjects',
            'salary_structures',
            'teacher_allocations',
            'attendances',
            'teacher_attendances',
            'financial_years',
            'accounting_transactions',
            'exams',
            'exam_schedules',
            'grades',
            'marks',
            'fee_types',
            'fee_invoices',
            'fee_structures',
            'fee_payments',
            'account_categories',
            'transactions',
            'staff_salaries',
            'staff_allowances',
            'staff_deductions',
            'payslips',
            'notices',
            'events',
            'messages',
            'audit_logs',
            'leave_requests',
            'performance_reviews',
            'inventory_items',
            'inventory_purchases',
            'inventory_issues',
            'inventory_returns',
            'drivers',
            'transport_routes',
            'vehicles',
            'student_transports',
            'library_books',
            'library_loans',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                // Check if column exists first to avoid errors on re-run
                if (!Schema::hasColumn($table, 'school_id')) {
                    Schema::table($table, function (Blueprint $table) {
                        $table->foreignId('school_id')->nullable()->after('id')->constrained('schools')->onDelete('cascade');
                    });
                }
            }
        }
    }

    public function down(): void
    {
        $tables = [
            'users',
            'students',
            'teachers',
            'school_classes',
            'sections',
            'subjects',
            'salary_structures',
            'teacher_allocations',
            'attendances',
            'teacher_attendances',
            'financial_years',
            'accounting_transactions',
            'exams',
            'exam_schedules',
            'grades',
            'marks',
            'fee_types',
            'fee_invoices',
            'fee_structures',
            'fee_payments',
            'account_categories',
            'transactions',
            'staff_salaries',
            'staff_allowances',
            'staff_deductions',
            'payslips',
            'notices',
            'events',
            'messages',
            'audit_logs',
            'leave_requests',
            'performance_reviews',
            'inventory_items',
            'inventory_purchases',
            'inventory_issues',
            'inventory_returns',
            'drivers',
            'transport_routes',
            'vehicles',
            'student_transports',
            'library_books',
            'library_loans',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                if (Schema::hasColumn($table, 'school_id')) {
                    Schema::table($table, function (Blueprint $table) {
                        $table->dropForeign(['school_id']);
                        $table->dropColumn('school_id');
                    });
                }
            }
        }
    }
}
