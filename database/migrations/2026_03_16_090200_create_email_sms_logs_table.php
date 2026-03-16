<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('email_sms_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->nullable()->constrained('schools')->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('channel', 20);
            $table->string('recipient_group', 50);
            $table->json('recipients');
            $table->string('subject');
            $table->text('message');
            $table->string('status', 20)->default('sent');
            $table->text('error_message')->nullable();
            $table->dateTime('sent_at')->nullable();
            $table->timestamps();

            $table->index(['school_id', 'channel', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('email_sms_logs');
    }
};
