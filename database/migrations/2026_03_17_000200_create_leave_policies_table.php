<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leave_policies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->enum('scope', ['teacher', 'student'])->index();
            $table->unsignedSmallInteger('year')->nullable()->index();
            $table->unsignedInteger('total_paid_leaves')->default(20);
            $table->json('weekend_days')->nullable();
            $table->unsignedSmallInteger('working_days_per_month')->nullable();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')->cascadeOnDelete();
            $table->unique(['school_id', 'scope', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leave_policies');
    }
};
