<?php

namespace Database\Seeders;

use App\Models\FinancialYear;
use Illuminate\Database\Seeder;

class FinancialYearSeeder extends Seeder
{
    public function run(): void
    {
        // Create current financial year (e.g., Apr 1, Current Year - Mar 31, Next Year)
        // Or Jan 1 - Dec 31 depending on region. Let's assume Academic Year style (Apr-Mar) or Jan-Dec.
        // Given "School ERP", Apr-Mar or Jun-May is common. Let's use current year Jan-Dec for simplicity unless specified.
        // Actually, let's create a range.

        $currentYear = date('Y');

        // Current Year
        FinancialYear::firstOrCreate([
            'name' => "$currentYear-".($currentYear + 1),
        ], [
            'start_date' => "$currentYear-04-01",
            'end_date' => ($currentYear + 1).'-03-31',
            'is_current' => true,
        ]);

        // Previous Year
        FinancialYear::firstOrCreate([
            'name' => ($currentYear - 1)."-$currentYear",
        ], [
            'start_date' => ($currentYear - 1).'-04-01',
            'end_date' => "$currentYear-03-31",
            'is_current' => false,
        ]);
    }
}
