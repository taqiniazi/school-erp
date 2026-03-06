<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\SalaryStructure;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            FinancialYearSeeder::class,
            SchoolClassSeeder::class,
            SubjectSeeder::class,
            SalaryStructureSeeder::class,
            FeeTypeSeeder::class,
        ]);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@school.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('password'),
            ]
        );
        $admin->assignRole('Super Admin');

        // Seed demo data only in local environment
        if (app()->isLocal()) {
            $this->seedDemoData();
        }
    }

    private function seedDemoData()
    {
        // Create teacher user
        $teacherUser = User::firstOrCreate(
            ['email' => 'teacher@school.com'],
            [
                'name' => 'Teacher User',
                'password' => bcrypt('password'),
            ]
        );
        $teacherUser->assignRole('Teacher');
        
        // Create teacher profile if not exists
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

        // Create student user
        $student = User::firstOrCreate(
            ['email' => 'student@school.com'],
            [
                'name' => 'Student User',
                'password' => bcrypt('password'),
            ]
        );
        $student->assignRole('Student');

        // Create parent user
        $parent = User::firstOrCreate(
            ['email' => 'parent@school.com'],
            [
                'name' => 'Parent User',
                'password' => bcrypt('password'),
            ]
        );
        $parent->assignRole('Parent');
    }
}
