<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $modules = [
            'admissions',
            'sis',
            'academics',
            'timetable',
            'attendance',
            'exams',
            'fees',
            'payroll',
            'inventory',
            'library',
            'transport',
            'messaging',
            'reporting',
            'settings',
        ];

        $actions = ['view', 'create', 'update', 'delete', 'approve', 'export', 'configure'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$module}.{$action}"]);
            }
        }

        $roles = [
            'Super Admin',
            'School Admin',
            'Principal',
            'Teacher',
            'Student',
            'Parent',
            'Accountant',
            'Librarian',
            'HR Manager',
        ];

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            if ($roleName === 'Super Admin' || $roleName === 'School Admin') {
                $role->syncPermissions(Permission::pluck('name')->all());
            }
        }
    }
}
