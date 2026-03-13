<?php

namespace Database\Seeders;

use App\Models\Campus;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\SuperAdmin;
use App\Models\Teacher;
use App\Models\User;
use App\Models\SalaryStructure;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

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
                'name' => 'Hawak School',
                'slug' => 'hawak-school',
                'is_active' => true
            ]);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        foreach (['Super Admin', 'School Admin', 'Teacher', 'Student', 'Parent'] as $roleName) {
            Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        }

        $mainCampus = Campus::firstOrCreate(
            ['school_id' => $school->id, 'name' => 'Main Campus'],
            [
                'school_id' => $school->id,
                'address' => '123 Main St',
                'phone' => '555-0100',
                'email' => 'campus@school.com',
                'is_main' => true,
                'is_active' => true,
            ]
        );

        $classes = SchoolClass::orderBy('numeric_value')->get();
        if ($classes->isEmpty()) {
            $classes = collect([
                SchoolClass::create(['name' => 'Class 1', 'numeric_value' => 1]),
            ]);
        }

        foreach ($classes as $class) {
            Section::firstOrCreate(
                ['name' => 'A', 'school_class_id' => $class->id],
                ['campus_id' => $mainCampus->id]
            );
            Section::firstOrCreate(
                ['name' => 'B', 'school_class_id' => $class->id],
                ['campus_id' => $mainCampus->id]
            );
        }

        $sectionsByClassId = Section::whereIn('school_class_id', $classes->pluck('id')->all())
            ->orderBy('name')
            ->get()
            ->groupBy('school_class_id');

        // Super Admin
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@school.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'school_id' => null,
            ]
        );
        if ($superAdmin->school_id !== null) {
            $superAdmin->school_id = null;
            $superAdmin->save();
        }
        $superAdmin->syncRoles('Super Admin');
        SuperAdmin::firstOrCreate(['user_id' => $superAdmin->id]);

        $superAdmin2 = User::firstOrCreate(
            ['email' => 'superadmin2@school.com'],
            [
                'name' => 'Super Admin 2',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'school_id' => null,
            ]
        );
        if ($superAdmin2->school_id !== null) {
            $superAdmin2->school_id = null;
            $superAdmin2->save();
        }
        $superAdmin2->syncRoles('Super Admin');
        SuperAdmin::firstOrCreate(['user_id' => $superAdmin2->id]);

        // School Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@school.com'],
            [
                'name' => 'School Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'school_id' => $school->id,
            ]
        );
        $admin->syncRoles('School Admin');

        $admin2 = User::firstOrCreate(
            ['email' => 'admin2@school.com'],
            [
                'name' => 'School Admin 2',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'school_id' => $school->id,
            ]
        );
        $admin2->syncRoles('School Admin');

        $salaryStructure = SalaryStructure::first();

        $teacherSeeds = [
            ['email' => 'teacher@school.com', 'name' => 'Teacher User'],
            ['email' => 'teacher2@school.com', 'name' => 'Ayesha Khan'],
            ['email' => 'teacher3@school.com', 'name' => 'Usman Ali'],
        ];

        foreach ($teacherSeeds as $t) {
            $teacherUser = User::firstOrCreate(
                ['email' => $t['email']],
                [
                    'name' => $t['name'],
                    'password' => Hash::make('password'),
                    'role' => 'teacher',
                    'school_id' => $school->id,
                ]
            );
            $teacherUser->syncRoles('Teacher');

            Teacher::firstOrCreate(
                ['user_id' => $teacherUser->id],
                [
                    'qualification' => 'B.Ed, M.Sc',
                    'joining_date' => now()->subMonths(18),
                    'address' => '123 School Lane',
                    'phone' => '555-0123',
                    'emergency_contact' => '555-0199',
                    'salary_structure_id' => $salaryStructure?->id,
                    'campus_id' => $mainCampus->id,
                    'status' => 'active',
                    'school_id' => $school->id,
                ]
            );
        }

        // Parent
        $parentSeeds = [
            ['email' => 'parent@school.com', 'name' => 'Parent User'],
            ['email' => 'parent2@school.com', 'name' => 'Sara Ahmed'],
            ['email' => 'parent3@school.com', 'name' => 'Imran Shah'],
        ];

        $parents = collect();
        foreach ($parentSeeds as $p) {
            $parentUser = User::firstOrCreate(
                ['email' => $p['email']],
                [
                    'name' => $p['name'],
                    'password' => Hash::make('password'),
                    'role' => 'parent',
                    'school_id' => $school->id,
                ]
            );
            $parentUser->syncRoles('Parent');
            $parents->push($parentUser);
        }

        $studentSeeds = [
            ['email' => 'student@school.com', 'name' => 'Student User', 'first' => 'Ali', 'last' => 'Raza', 'gender' => 'male'],
            ['email' => 'student2@school.com', 'name' => 'Fatima Noor', 'first' => 'Fatima', 'last' => 'Noor', 'gender' => 'female'],
            ['email' => 'student3@school.com', 'name' => 'Hassan Ali', 'first' => 'Hassan', 'last' => 'Ali', 'gender' => 'male'],
            ['email' => 'student4@school.com', 'name' => 'Areeba Khan', 'first' => 'Areeba', 'last' => 'Khan', 'gender' => 'female'],
            ['email' => 'student5@school.com', 'name' => 'Zain Ahmed', 'first' => 'Zain', 'last' => 'Ahmed', 'gender' => 'male'],
            ['email' => 'student6@school.com', 'name' => 'Maryam Iqbal', 'first' => 'Maryam', 'last' => 'Iqbal', 'gender' => 'female'],
            ['email' => 'student7@school.com', 'name' => 'Bilal Hussain', 'first' => 'Bilal', 'last' => 'Hussain', 'gender' => 'male'],
            ['email' => 'student8@school.com', 'name' => 'Hira Malik', 'first' => 'Hira', 'last' => 'Malik', 'gender' => 'female'],
            ['email' => 'student9@school.com', 'name' => 'Saad Khan', 'first' => 'Saad', 'last' => 'Khan', 'gender' => 'male'],
            ['email' => 'student10@school.com', 'name' => 'Noor Fatima', 'first' => 'Noor', 'last' => 'Fatima', 'gender' => 'female'],
        ];

        foreach ($studentSeeds as $i => $s) {
            $studentUser = User::firstOrCreate(
                ['email' => $s['email']],
                [
                    'name' => $s['name'],
                    'password' => Hash::make('password'),
                    'role' => 'student',
                    'school_id' => $school->id,
                ]
            );
            $studentUser->syncRoles('Student');

            $class = $classes[$i % $classes->count()];
            $section = ($sectionsByClassId[$class->id] ?? collect())->first() ?? Section::where('school_class_id', $class->id)->first();

            $studentProfile = Student::updateOrCreate(
                ['user_id' => $studentUser->id],
                [
                    'admission_number' => sprintf('STD-%04d', $i + 1),
                    'roll_number' => (string) ($i + 1),
                    'first_name' => $s['first'],
                    'last_name' => $s['last'],
                    'dob' => now()->subYears(10)->subDays(($i + 1) * 30)->toDateString(),
                    'gender' => $s['gender'],
                    'address' => '123 Student Street',
                    'phone' => '555-0200',
                    'email' => $s['email'],
                    'school_class_id' => $class->id,
                    'section_id' => $section?->id ?? Section::first()->id,
                    'campus_id' => $mainCampus->id,
                    'status' => 'active',
                    'admission_date' => now()->subMonths(6)->toDateString(),
                    'photo_path' => null,
                    'school_id' => $school->id,
                ]
            );

            $primaryParent = $parents[$i % $parents->count()];
            $secondaryParent = $parents[($i + 1) % $parents->count()];

            $studentProfile->parents()->sync([
                $primaryParent->id => ['relation' => 'Guardian'],
                $secondaryParent->id => ['relation' => 'Guardian'],
            ]);
        }
    }
}
