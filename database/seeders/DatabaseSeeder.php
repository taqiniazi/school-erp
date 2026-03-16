<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\School;
use App\Models\Subscription;
use App\Services\SchoolContext;
use Illuminate\Database\Seeder;

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
            DummyDataSeeder::class,
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
