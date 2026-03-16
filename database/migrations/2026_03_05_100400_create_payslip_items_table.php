<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payslip_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('payslip_id');
            $table->enum('type', ['allowance', 'deduction']);
            $table->string('name');
            $table->boolean('is_percentage')->default(false);
            $table->decimal('value', 12, 2)->default(0); // percentage or fixed
            $table->decimal('amount', 12, 2)->default(0); // computed amount
            $table->timestamps();

            $table->foreign('payslip_id')->references('id')->on('payslips')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payslip_items');
    }
};
