<?php

namespace Database\Seeders;

use App\Models\Campus;
use App\Models\SalaryStructure;
use App\Models\School;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Student;
use App\Models\SuperAdmin;
use App\Models\Teacher;
use App\Models\User;
use App\Services\SchoolContext;
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

        if (! $school) {
            $school = School::create([
                'name' => 'Hawak School',
                'slug' => 'hawak-school',
                'is_active' => true,
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

        // Super Admin (disable school context to avoid tenant scope and auto-assign)
        $prevSchoolId = SchoolContext::getSchoolId();
        SchoolContext::setSchoolId(null);
        $superAdmin = User::withoutGlobalScope('school')->firstOrCreate(
            ['email' => 'superadmin@school.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'school_id' => null,
            ]
        );
        $superAdmin->school_id = null;
        $superAdmin->save();
        $superAdmin->syncRoles('Super Admin');
        SuperAdmin::firstOrCreate(['user_id' => $superAdmin->id]);

        $superAdmin2 = User::withoutGlobalScope('school')->firstOrCreate(
            ['email' => 'superadmin2@school.com'],
            [
                'name' => 'Super Admin 2',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'school_id' => null,
            ]
        );
        $superAdmin2->school_id = null;
        $superAdmin2->save();
        $superAdmin2->syncRoles('Super Admin');
        SuperAdmin::firstOrCreate(['user_id' => $superAdmin2->id]);
        // Restore previous school context
        if ($prevSchoolId !== null) {
            SchoolContext::setSchoolId($prevSchoolId);
        }

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
            ['email' => 'teacher4@school.com', 'name' => 'Zia Ahmed'],
            ['email' => 'teacher5@school.com', 'name' => 'Sobia Malik'],
            ['email' => 'teacher6@school.com', 'name' => 'Irfan Hussain'],
            ['email' => 'teacher7@school.com', 'name' => 'Nida Shah'],
            ['email' => 'teacher8@school.com', 'name' => 'Bilal Khan'],
            ['email' => 'teacher9@school.com', 'name' => 'Zoya Ali'],
            ['email' => 'teacher10@school.com', 'name' => 'Haris Iqbal'],
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
            ['email' => 'student11@school.com', 'name' => 'Umer Ali', 'first' => 'Umer', 'last' => 'Ali', 'gender' => 'male'],
            ['email' => 'student12@school.com', 'name' => 'Sana Ahmed', 'first' => 'Sana', 'last' => 'Ahmed', 'gender' => 'female'],
            ['email' => 'student13@school.com', 'name' => 'Hamza Khan', 'first' => 'Hamza', 'last' => 'Khan', 'gender' => 'male'],
            ['email' => 'student14@school.com', 'name' => 'Dua Malik', 'first' => 'Dua', 'last' => 'Malik', 'gender' => 'female'],
            ['email' => 'student15@school.com', 'name' => 'Taha Hussain', 'first' => 'Taha', 'last' => 'Hussain', 'gender' => 'male'],
            ['email' => 'student16@school.com', 'name' => 'Ayesha Noor', 'first' => 'Ayesha', 'last' => 'Noor', 'gender' => 'female'],
            ['email' => 'student17@school.com', 'name' => 'Zaid Ali', 'first' => 'Zaid', 'last' => 'Ali', 'gender' => 'male'],
            ['email' => 'student18@school.com', 'name' => 'Laiba Khan', 'first' => 'Laiba', 'last' => 'Khan', 'gender' => 'female'],
            ['email' => 'student19@school.com', 'name' => 'Abdullah Ahmed', 'first' => 'Abdullah', 'last' => 'Ahmed', 'gender' => 'male'],
            ['email' => 'student20@school.com', 'name' => 'Khadija Bibi', 'first' => 'Khadija', 'last' => 'Bibi', 'gender' => 'female'],
            ['email' => 'student21@school.com', 'name' => 'Mustafa Khan', 'first' => 'Mustafa', 'last' => 'Khan', 'gender' => 'male'],
            ['email' => 'student22@school.com', 'name' => 'Sadia Malik', 'first' => 'Sadia', 'last' => 'Malik', 'gender' => 'female'],
            ['email' => 'student23@school.com', 'name' => 'Usama Ali', 'first' => 'Usama', 'last' => 'Ali', 'gender' => 'male'],
            ['email' => 'student24@school.com', 'name' => 'Hafsa Noor', 'first' => 'Hafsa', 'last' => 'Noor', 'gender' => 'female'],
            ['email' => 'student25@school.com', 'name' => 'Rayyan Ahmed', 'first' => 'Rayyan', 'last' => 'Ahmed', 'gender' => 'male'],
            ['email' => 'student26@school.com', 'name' => 'Amna Khan', 'first' => 'Amna', 'last' => 'Khan', 'gender' => 'female'],
            ['email' => 'student27@school.com', 'name' => 'Ibrahim Hussain', 'first' => 'Ibrahim', 'last' => 'Hussain', 'gender' => 'male'],
            ['email' => 'student28@school.com', 'name' => 'Zainab Bibi', 'first' => 'Zainab', 'last' => 'Bibi', 'gender' => 'female'],
            ['email' => 'student29@school.com', 'name' => 'Yahya Ali', 'first' => 'Yahya', 'last' => 'Ali', 'gender' => 'male'],
            ['email' => 'student30@school.com', 'name' => 'Sumaira Malik', 'first' => 'Sumaira', 'last' => 'Malik', 'gender' => 'female'],
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
