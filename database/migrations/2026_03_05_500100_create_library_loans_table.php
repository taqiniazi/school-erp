<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('library_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('library_book_id')->constrained('library_books')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->dateTime('issued_at');
            $table->date('due_date');
            $table->dateTime('returned_at')->nullable();
            $table->decimal('per_day_fine', 10, 2)->default(5.00);
            $table->decimal('fine_amount', 10, 2)->default(0.00);
            $table->enum('status', ['issued', 'returned'])->default('issued');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('library_loans');
    }
};
