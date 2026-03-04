<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
        ]);

        // Create admin user
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@school.com',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole('Super Admin');

        // Create teacher user
        $teacher = \App\Models\User::factory()->create([
            'name' => 'Teacher User',
            'email' => 'teacher@school.com',
            'password' => bcrypt('password'),
        ]);
        $teacher->assignRole('Teacher');

        // Create student user
        $student = \App\Models\User::factory()->create([
            'name' => 'Student User',
            'email' => 'student@school.com',
            'password' => bcrypt('password'),
        ]);
        $student->assignRole('Student');

        // Create parent user
        $parent = \App\Models\User::factory()->create([
            'name' => 'Parent User',
            'email' => 'parent@school.com',
            'password' => bcrypt('password'),
        ]);
        $parent->assignRole('Parent');
    }
}
