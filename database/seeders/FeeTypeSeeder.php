<?php

namespace Database\Seeders;

use App\Models\FeeType;
use Illuminate\Database\Seeder;

class FeeTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Admission Fee', 'description' => 'One-time fee for new admissions'],
            ['name' => 'Tuition Fee', 'description' => 'Monthly tuition fee'],
            ['name' => 'Exam Fee', 'description' => 'Fee for term examinations'],
            ['name' => 'Transport Fee', 'description' => 'Monthly transport charges'],
            ['name' => 'Library Fee', 'description' => 'Annual library membership fee'],
            ['name' => 'Lab Fee', 'description' => 'Fee for science/computer labs'],
            ['name' => 'Sports Fee', 'description' => 'Annual sports facility fee'],
        ];

        foreach ($types as $type) {
            FeeType::firstOrCreate(['name' => $type['name']], $type);
        }
    }
}
