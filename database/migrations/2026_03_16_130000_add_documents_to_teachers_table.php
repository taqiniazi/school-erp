<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            if (! Schema::hasColumn('teachers', 'degree_certificate_path')) {
                $table->string('degree_certificate_path')->nullable()->after('photo_path');
            }
            if (! Schema::hasColumn('teachers', 'cnic_front_path')) {
                $table->string('cnic_front_path')->nullable()->after('degree_certificate_path');
            }
            if (! Schema::hasColumn('teachers', 'cnic_back_path')) {
                $table->string('cnic_back_path')->nullable()->after('cnic_front_path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            if (Schema::hasColumn('teachers', 'cnic_back_path')) {
                $table->dropColumn('cnic_back_path');
            }
            if (Schema::hasColumn('teachers', 'cnic_front_path')) {
                $table->dropColumn('cnic_front_path');
            }
            if (Schema::hasColumn('teachers', 'degree_certificate_path')) {
                $table->dropColumn('degree_certificate_path');
            }
        });
    }
};
