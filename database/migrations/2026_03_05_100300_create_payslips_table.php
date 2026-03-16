<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payslips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('financial_year_id')->nullable();
            $table->string('payslip_no')->unique();
            $table->date('pay_month'); // use first day of month
            $table->decimal('basic_salary', 12, 2)->default(0);
            $table->decimal('total_allowances', 12, 2)->default(0);
            $table->decimal('total_deductions', 12, 2)->default(0);
            $table->decimal('net_salary', 12, 2)->default(0);
            $table->unsignedBigInteger('generated_by')->nullable();
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('teachers')->cascadeOnDelete();
            $table->foreign('financial_year_id')->references('id')->on('financial_years')->nullOnDelete();
            $table->foreign('generated_by')->references('id')->on('users')->nullOnDelete();
            $table->index(['teacher_id', 'pay_month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payslips');
    }
};
