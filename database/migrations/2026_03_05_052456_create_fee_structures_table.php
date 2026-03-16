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
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_class_id')->constrained()->onDelete('cascade');
            $table->foreignId('fee_type_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('academic_year')->nullable();
            // 1: Monthly, 2: Quarterly, 3: Annually, 0: One-time
            $table->tinyInteger('frequency')->default(1);
            $table->timestamps();

            $table->unique(['school_class_id', 'fee_type_id', 'academic_year'], 'unique_fee_structure');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_structures');
    }
};
