<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('marks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('exam_schedule_id')->constrained()->onDelete('cascade');
            $table->integer('marks_obtained');
            $table->text('remarks')->nullable();
            $table->foreignId('user_id')->nullable()->constrained(); // Teacher who entered marks
            $table->timestamps();

            $table->unique(['student_id', 'exam_schedule_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marks');
    }
};
