<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\SalaryStructure;
use App\Models\School;
use App\Services\SchoolContext;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::firstOrCreate(
            ['slug' => 'default-school'],
            ['name' => 'Default School', 'address' => '123 Main St', 'is_active' => true]
        );

        SchoolContext::setSchoolId($school->id);

        $this->call([
            RolesAndPermissionsSeeder::class,
            FinancialYearSeeder::class,
            SchoolClassSeeder::class,
            SubjectSeeder::class,
            SalaryStructureSeeder::class,
            FeeTypeSeeder::class,
        ]);

        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@school.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
                'school_id' => $school->id,
            ]
        );
        $superAdmin->syncRoles('Super Admin');

        $admin = User::firstOrCreate(
            ['email' => 'admin@school.com'],
            [
                'name' => 'School Admin',
                'password' => bcrypt('password'),
                'school_id' => $school->id,
            ]
        );
        $admin->syncRoles('School Admin');

        if (app()->isLocal()) {
            $this->seedDemoData($school);
        }
    }

    private function seedDemoData($school)
    {
        $teacherUser = User::firstOrCreate(
            ['email' => 'teacher@school.com'],
            [
                'name' => 'Teacher User',
                'password' => bcrypt('password'),
                'school_id' => $school->id,
            ]
        );
        $teacherUser->assignRole('Teacher');
        
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
            ]);
        }

        $student = User::firstOrCreate(
            ['email' => 'student@school.com'],
            [
                'name' => 'Student User',
                'password' => bcrypt('password'),
                'school_id' => $school->id,
            ]
        );
        $student->assignRole('Student');

        $parent = User::firstOrCreate(
            ['email' => 'parent@school.com'],
            [
                'name' => 'Parent User',
                'password' => bcrypt('password'),
                'school_id' => $school->id,
            ]
        );
        $parent->assignRole('Parent');
    }
}
