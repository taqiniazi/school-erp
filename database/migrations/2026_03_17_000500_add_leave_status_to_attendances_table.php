<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE `attendances` MODIFY `status` ENUM('present','absent','late','leave','half_day','holiday') NOT NULL DEFAULT 'present'");
        }

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE attendances ALTER COLUMN status TYPE varchar(20)');
        }
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            DB::statement("ALTER TABLE `attendances` MODIFY `status` ENUM('present','absent','late','half_day','holiday') NOT NULL DEFAULT 'present'");
        }
    }
};
