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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Optional link to user login
            $table->string('admission_number')->unique();
            $table->string('roll_number')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('dob');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->text('address');
            $table->string('phone')->nullable();
            $table->string('email')->nullable(); // Contact email (might differ from user login)

            // Class & Section
            $table->foreignId('school_class_id')->constrained('school_classes');
            $table->foreignId('section_id')->constrained('sections');

            // Status
            $table->enum('status', ['active', 'graduated', 'left'])->default('active');
            $table->date('admission_date');
            $table->string('photo_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
