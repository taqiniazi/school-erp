<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;
use App\Models\Subscription;
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
            PlanSeeder::class,
            PaymentMethodSeeder::class,
            FinancialYearSeeder::class,
            SchoolClassSeeder::class,
            SubjectSeeder::class,
            SalaryStructureSeeder::class,
            FeeTypeSeeder::class,
            UserSeeder::class,
        ]);

        // Assign Enterprise Plan to Default School
        $plan = Plan::where('code', 'enterprise_monthly')->first();
        if ($plan) {
            Subscription::firstOrCreate(
                ['school_id' => $school->id, 'status' => 'active'],
                [
                    'plan_id' => $plan->id,
                    'current_period_start' => now(),
                    'current_period_end' => now()->addYear(),
                ]
            );
        }
    }
}
