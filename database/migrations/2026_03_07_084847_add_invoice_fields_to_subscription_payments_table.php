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
        Schema::table('subscription_payments', function (Blueprint $table) {
            $table->string('invoice_number')->nullable()->unique()->after('status');
            $table->date('invoice_date')->nullable()->after('invoice_number');
            $table->decimal('subtotal', 10, 2)->default(0)->after('amount');
            $table->decimal('tax_amount', 10, 2)->default(0)->after('subtotal');
            $table->decimal('tax_percentage', 5, 2)->default(0)->after('tax_amount');
            $table->json('billing_details')->nullable()->after('tax_percentage'); // Snapshots address, tax_id etc.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subscription_payments', function (Blueprint $table) {
            $table->dropColumn([
                'invoice_number',
                'invoice_date',
                'subtotal',
                'tax_amount',
                'tax_percentage',
                'billing_details',
            ]);
        });
    }
};
