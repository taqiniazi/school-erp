<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_deductions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('teacher_id');
            $table->unsignedSmallInteger('year');
            $table->unsignedTinyInteger('month');
            $table->string('type', 50)->index();
            $table->unsignedInteger('days')->default(0);
            $table->decimal('amount', 12, 2)->default(0);
            $table->unsignedBigInteger('leave_request_id')->nullable();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->foreign('teacher_id')->references('id')->on('teachers')->cascadeOnDelete();
            $table->foreign('leave_request_id')->references('id')->on('leave_requests')->nullOnDelete();
            $table->unique(['teacher_id', 'year', 'month', 'type', 'leave_request_id'], 'sd_teacher_year_month_type_leave_uq');
            $table->index(['teacher_id', 'year', 'month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_deductions');
    }
};
