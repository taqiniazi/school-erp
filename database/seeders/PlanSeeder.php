<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Standard',
                'code' => 'standard_monthly',
                'price' => 50.00,
                'billing_cycle' => 'monthly',
                'max_students' => 500,
                'max_teachers' => 50,
                'max_campuses' => 1,
                'storage_limit_mb' => 10240, // 10 GB
                'allowed_modules' => ['academic', 'attendance', 'communication', 'fees', 'reports'],
                'features' => [
                    'Up to 500 Students',
                    'Up to 50 Teachers',
                    '1 Campus',
                    '10 GB Storage',
                    'Core Modules (Academic, Attendance, Fees)',
                    'Email Support'
                ]
            ],
            [
                'name' => 'Premium',
                'code' => 'premium_monthly',
                'price' => 150.00,
                'billing_cycle' => 'monthly',
                'max_students' => 2000,
                'max_teachers' => 200,
                'max_campuses' => 3,
                'storage_limit_mb' => 51200, // 50 GB
                'allowed_modules' => ['academic', 'attendance', 'communication', 'fees', 'reports', 'hr', 'payroll', 'library', 'transport'],
                'features' => [
                    'Up to 2000 Students',
                    'Up to 200 Teachers',
                    'Up to 3 Campuses',
                    '50 GB Storage',
                    'All Standard Modules + HR, Payroll, Library, Transport',
                    'Priority Email Support'
                ]
            ],
            [
                'name' => 'Enterprise',
                'code' => 'enterprise_monthly',
                'price' => 400.00,
                'billing_cycle' => 'monthly',
                'max_students' => null, // Unlimited
                'max_teachers' => null, // Unlimited
                'max_campuses' => null, // Unlimited
                'storage_limit_mb' => null, // Unlimited
                'allowed_modules' => ['*'], // All modules
                'features' => [
                    'Unlimited Students',
                    'Unlimited Teachers',
                    'Unlimited Campuses',
                    'Unlimited Storage',
                    'All Modules Included',
                    'Dedicated Account Manager',
                    '24/7 Phone Support',
                    'Custom Integrations'
                ]
            ],
        ];

        foreach ($plans as $plan) {
            Plan::updateOrCreate(
                ['code' => $plan['code']],
                $plan
            );
        }
    }
}
