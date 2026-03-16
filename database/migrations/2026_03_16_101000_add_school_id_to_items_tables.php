<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('fee_invoice_items') && ! Schema::hasColumn('fee_invoice_items', 'school_id')) {
            Schema::table('fee_invoice_items', function (Blueprint $table) {
                $table->foreignId('school_id')->nullable()->after('id')->constrained('schools')->cascadeOnDelete();
            });
        }

        if (Schema::hasTable('payslip_items') && ! Schema::hasColumn('payslip_items', 'school_id')) {
            Schema::table('payslip_items', function (Blueprint $table) {
                $table->foreignId('school_id')->nullable()->after('id')->constrained('schools')->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('fee_invoice_items') && Schema::hasColumn('fee_invoice_items', 'school_id')) {
            Schema::table('fee_invoice_items', function (Blueprint $table) {
                $table->dropForeign(['school_id']);
                $table->dropColumn('school_id');
            });
        }

        if (Schema::hasTable('payslip_items') && Schema::hasColumn('payslip_items', 'school_id')) {
            Schema::table('payslip_items', function (Blueprint $table) {
                $table->dropForeign(['school_id']);
                $table->dropColumn('school_id');
            });
        }
    }
};

