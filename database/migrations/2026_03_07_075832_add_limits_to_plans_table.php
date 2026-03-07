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
        Schema::table('plans', function (Blueprint $table) {
            $table->integer('max_students')->nullable()->after('billing_cycle')->comment('Null means unlimited');
            $table->integer('max_teachers')->nullable()->after('max_students')->comment('Null means unlimited');
            $table->integer('max_campuses')->nullable()->default(1)->after('max_teachers')->comment('Default 1, Null means unlimited');
            $table->integer('storage_limit_mb')->nullable()->after('max_campuses')->comment('In MB, Null means unlimited');
            $table->json('allowed_modules')->nullable()->after('storage_limit_mb')->comment('List of accessible modules');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn(['max_students', 'max_teachers', 'max_campuses', 'storage_limit_mb', 'allowed_modules']);
        });
    }
};
