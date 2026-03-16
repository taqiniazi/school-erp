<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff_profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('teacher_id');
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->date('join_date')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();

            $table->foreign('teacher_id')->references('id')->on('teachers')->cascadeOnDelete();
            $table->unique('teacher_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_profiles');
    }
};
