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
        // Students
        Schema::table('students', function (Blueprint $table) {
            $table->index('status');
            $table->index('email');
        });

        // Fee Invoices
        Schema::table('fee_invoices', function (Blueprint $table) {
            $table->index('status');
            $table->index('due_date');
        });

        // Fee Payments
        Schema::table('fee_payments', function (Blueprint $table) {
            $table->index('payment_date');
        });

        // Inventory Items
        Schema::table('inventory_items', function (Blueprint $table) {
            $table->index('current_stock');
            $table->index('reorder_level');
        });

        // Leave Requests
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->index('status');
        });

        // Notices
        Schema::table('notices', function (Blueprint $table) {
            $table->index(['audience_role', 'created_at']); // Composite index for recent notices query
        });

        // Events
        Schema::table('events', function (Blueprint $table) {
            $table->index('start_date');
        });
        
        // Attendances
        Schema::table('attendances', function (Blueprint $table) {
             $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['email']);
        });

        Schema::table('fee_invoices', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['due_date']);
        });

        Schema::table('fee_payments', function (Blueprint $table) {
            $table->dropIndex(['payment_date']);
        });

        Schema::table('inventory_items', function (Blueprint $table) {
            $table->dropIndex(['current_stock']);
            $table->dropIndex(['reorder_level']);
        });

        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('notices', function (Blueprint $table) {
            $table->dropIndex(['audience_role', 'created_at']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['start_date']);
        });
        
        Schema::table('attendances', function (Blueprint $table) {
             $table->dropIndex(['status']);
        });
    }
};
