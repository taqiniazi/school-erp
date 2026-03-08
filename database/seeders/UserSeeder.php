<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Teacher;
use App\Models\User;
use App\Models\SalaryStructure;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school = School::first(); // Assuming school is already created by DatabaseSeeder
        
        if (!$school) {
            $school = School::create([
                'name' => 'Default School',
                'slug' => 'default-school',
                'is_active' => true
            ]);
        }

        // Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@school.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'school_id' => $school->id,
            ]
        );
        $superAdmin->syncRoles('Super Admin');

        // School Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@school.com'],
            [
                'name' => 'School Admin',
                'password' => Hash::make('password'),
                'role' => 'school_admin',
                'school_id' => $school->id,
            ]
        );
        $admin->syncRoles('School Admin');

        // Teacher
        $teacherUser = User::firstOrCreate(
            ['email' => 'teacher@school.com'],
            [
                'name' => 'Teacher User',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'school_id' => $school->id,
            ]
        );
        $teacherUser->syncRoles('Teacher');
        
        if (!$teacherUser->teacherProfile) {
            $salaryStructure = SalaryStructure::first();
            Teacher::create([
                'user_id' => $teacherUser->id,
                'qualification' => 'B.Ed, M.Sc',
                'joining_date' => now(),
                'address' => '123 School Lane',
                'phone' => '1234567890',
                'emergency_contact' => '0987654321',
                'salary_structure_id' => $salaryStructure ? $salaryStructure->id : null,
                'status' => 'active',
                'school_id' => $school->id,
            ]);
        }

        // Student
        $student = User::firstOrCreate(
            ['email' => 'student@school.com'],
            [
                'name' => 'Student User',
                'password' => Hash::make('password'),
                'role' => 'student',
                'school_id' => $school->id,
            ]
        );
        $student->syncRoles('Student');

        // Parent
        $parent = User::firstOrCreate(
            ['email' => 'parent@school.com'],
            [
                'name' => 'Parent User',
                'password' => Hash::make('password'),
                'role' => 'parent',
                'school_id' => $school->id,
            ]
        );
        $parent->syncRoles('Parent');
    }
}
