<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->text('remarks')->nullable()->after('reason');
            $table->string('attachment_path')->nullable()->after('remarks');
            $table->unsignedInteger('total_days')->nullable()->after('attachment_path');
            $table->unsignedInteger('paid_days')->nullable()->after('total_days');
            $table->unsignedInteger('unpaid_days')->nullable()->after('paid_days');
            $table->decimal('deduction_amount', 12, 2)->default(0)->after('unpaid_days');
            $table->timestamp('processed_at')->nullable()->after('approved_at');

            $table->index(['status', 'approved_at']);
        });
    }

    public function down(): void
    {
        Schema::table('leave_requests', function (Blueprint $table) {
            $table->dropIndex(['status', 'approved_at']);

            $table->dropColumn([
                'remarks',
                'attachment_path',
                'total_days',
                'paid_days',
                'unpaid_days',
                'deduction_amount',
                'processed_at',
            ]);
        });
    }
};
