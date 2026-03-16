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
        Schema::table('students', function (Blueprint $table) {
            if (! Schema::hasColumn('students', 'school_id')) {
                $table->foreignId('school_id')->nullable()->after('id')->constrained('schools')->onDelete('cascade');
            }
            if (! Schema::hasColumn('students', 'deleted_at')) {
                $table->softDeletes();
            }
        });

        Schema::table('teachers', function (Blueprint $table) {
            if (! Schema::hasColumn('teachers', 'school_id')) {
                $table->foreignId('school_id')->nullable()->after('id')->constrained('schools')->onDelete('cascade');
            }
            if (! Schema::hasColumn('teachers', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (Schema::hasColumn('students', 'school_id')) {
                $table->dropForeign(['school_id']);
                $table->dropColumn('school_id');
            }
            if (Schema::hasColumn('students', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });

        Schema::table('teachers', function (Blueprint $table) {
            if (Schema::hasColumn('teachers', 'school_id')) {
                $table->dropForeign(['school_id']);
                $table->dropColumn('school_id');
            }
            if (Schema::hasColumn('teachers', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
