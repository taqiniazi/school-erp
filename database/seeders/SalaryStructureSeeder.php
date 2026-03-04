<?php

namespace Database\Seeders;

use App\Models\SalaryStructure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SalaryStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $structures = [
            ['grade' => 'Grade A', 'basic_salary' => 50000.00, 'description' => 'Senior Teachers'],
            ['grade' => 'Grade B', 'basic_salary' => 40000.00, 'description' => 'Intermediate Teachers'],
            ['grade' => 'Grade C', 'basic_salary' => 30000.00, 'description' => 'Junior Teachers'],
            ['grade' => 'Grade D', 'basic_salary' => 20000.00, 'description' => 'Assistant Teachers'],
        ];

        foreach ($structures as $structure) {
            SalaryStructure::firstOrCreate(['grade' => $structure['grade']], $structure);
        }
    }
}
