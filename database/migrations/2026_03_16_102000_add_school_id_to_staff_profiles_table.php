<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('staff_profiles')) {
            return;
        }

        if (! Schema::hasColumn('staff_profiles', 'school_id')) {
            Schema::table('staff_profiles', function (Blueprint $table) {
                $table->foreignId('school_id')->nullable()->after('id')->constrained('schools')->cascadeOnDelete();
            });
        }

        DB::table('staff_profiles')
            ->whereNull('school_id')
            ->orderBy('id')
            ->chunkById(500, function ($rows) {
                $teacherIds = collect($rows)->pluck('teacher_id')->filter()->unique()->values();
                if ($teacherIds->isEmpty()) {
                    return;
                }

                $teacherSchoolIds = DB::table('teachers')
                    ->whereIn('id', $teacherIds)
                    ->pluck('school_id', 'id');

                foreach ($rows as $row) {
                    $schoolId = $teacherSchoolIds[$row->teacher_id] ?? null;
                    if ($schoolId === null) {
                        continue;
                    }
                    DB::table('staff_profiles')->where('id', $row->id)->update(['school_id' => $schoolId]);
                }
            });
    }

    public function down(): void
    {
        if (! Schema::hasTable('staff_profiles') || ! Schema::hasColumn('staff_profiles', 'school_id')) {
            return;
        }

        Schema::table('staff_profiles', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropColumn('school_id');
        });
    }
};
