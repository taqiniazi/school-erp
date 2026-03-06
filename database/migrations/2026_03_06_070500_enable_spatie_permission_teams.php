<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EnableSpatiePermissionTeams extends Migration
{
    public function up(): void
    {
        // roles: add school_id and adjust unique index
        if (Schema::hasTable('roles')) {
            Schema::table('roles', function (Blueprint $table) {
                if (!Schema::hasColumn('roles', 'school_id')) {
                    $table->foreignId('school_id')->nullable()->after('id')->constrained('schools')->onDelete('cascade');
                }
                if (!Schema::hasColumn('roles', 'roles_school_id_index')) {
                    $table->index('school_id', 'roles_school_id_index');
                }
            });
        }

        // model_has_roles: add school_id and index (skip changing primary to avoid FK issues)
        if (Schema::hasTable('model_has_roles')) {
            Schema::table('model_has_roles', function (Blueprint $table) {
                if (!Schema::hasColumn('model_has_roles', 'school_id')) {
                    $table->foreignId('school_id')->nullable()->after('role_id')->constrained('schools')->onDelete('cascade');
                }
                $table->index(['model_id', 'model_type', 'school_id'], 'model_has_roles_model_id_model_type_school_id_index');
            });
        }

        // model_has_permissions: add school_id and index (skip changing primary)
        if (Schema::hasTable('model_has_permissions')) {
            Schema::table('model_has_permissions', function (Blueprint $table) {
                if (!Schema::hasColumn('model_has_permissions', 'school_id')) {
                    $table->foreignId('school_id')->nullable()->after('permission_id')->constrained('schools')->onDelete('cascade');
                }
                $table->index(['model_id', 'model_type', 'school_id'], 'model_has_permissions_model_id_model_type_school_id_index');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('roles')) {
            Schema::table('roles', function (Blueprint $table) {
                try {
                    $table->dropUnique('roles_name_guard_name_school_id_unique');
                } catch (\Throwable $e) {
                    // ignore
                }
                if (Schema::hasColumn('roles', 'school_id')) {
                    $table->dropConstrainedForeignId('school_id');
                }
                $table->unique(['name', 'guard_name'], 'roles_name_guard_name_unique');
            });
        }

        if (Schema::hasTable('model_has_roles')) {
            Schema::table('model_has_roles', function (Blueprint $table) {
                if (Schema::hasColumn('model_has_roles', 'school_id')) {
                    $table->dropConstrainedForeignId('school_id');
                }
                try {
                    $table->dropIndex('model_has_roles_model_id_model_type_school_id_index');
                } catch (\Throwable $e) {
                    // ignore
                }
                $table->index(['model_id', 'model_type'], 'model_has_roles_model_id_model_type_index');
            });
        }

        if (Schema::hasTable('model_has_permissions')) {
            Schema::table('model_has_permissions', function (Blueprint $table) {
                if (Schema::hasColumn('model_has_permissions', 'school_id')) {
                    $table->dropConstrainedForeignId('school_id');
                }
                try {
                    $table->dropIndex('model_has_permissions_model_id_model_type_school_id_index');
                } catch (\Throwable $e) {
                    // ignore
                }
                $table->index(['model_id', 'model_type'], 'model_has_permissions_model_id_model_type_index');
            });
        }
    }
}
