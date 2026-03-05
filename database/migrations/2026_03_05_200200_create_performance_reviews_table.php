<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('performance_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->date('review_date');
            $table->decimal('score', 5, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('reviewer_id')->nullable();
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('teachers')->cascadeOnDelete();
            $table->foreign('reviewer_id')->references('id')->on('users')->nullOnDelete();
            $table->index(['teacher_id', 'review_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('performance_reviews');
    }
};

