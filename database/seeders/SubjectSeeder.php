<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['name' => 'Mathematics', 'code' => 'MATH101', 'type' => 'theory'],
            ['name' => 'Science', 'code' => 'SCI101', 'type' => 'both'],
            ['name' => 'English', 'code' => 'ENG101', 'type' => 'theory'],
            ['name' => 'History', 'code' => 'HIST101', 'type' => 'theory'],
            ['name' => 'Computer Science', 'code' => 'CS101', 'type' => 'both'],
            ['name' => 'Physics', 'code' => 'PHY101', 'type' => 'both'],
            ['name' => 'Chemistry', 'code' => 'CHEM101', 'type' => 'both'],
            ['name' => 'Biology', 'code' => 'BIO101', 'type' => 'both'],
            ['name' => 'Physical Education', 'code' => 'PE101', 'type' => 'practical'],
        ];

        foreach ($subjects as $subject) {
            Subject::firstOrCreate(['code' => $subject['code']], $subject);
        }
    }
}
