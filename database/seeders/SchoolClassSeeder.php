<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            ['name' => 'Class 1', 'numeric_value' => 1],
            ['name' => 'Class 2', 'numeric_value' => 2],
            ['name' => 'Class 3', 'numeric_value' => 3],
            ['name' => 'Class 4', 'numeric_value' => 4],
            ['name' => 'Class 5', 'numeric_value' => 5],
        ];

        foreach ($classes as $classData) {
            $class = SchoolClass::firstOrCreate(
                ['name' => $classData['name']],
                $classData
            );

            Section::firstOrCreate(['name' => 'A', 'school_class_id' => $class->id]);
            Section::firstOrCreate(['name' => 'B', 'school_class_id' => $class->id]);
        }
    }
}
