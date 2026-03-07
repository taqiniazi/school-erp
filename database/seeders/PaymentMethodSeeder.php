<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'name' => 'Stripe',
                'type' => 'gateway',
                'instructions' => 'Pay securely with Credit/Debit Card via Stripe.',
                'account_details' => [],
                'is_active' => true,
            ],
            [
                'name' => 'PayPal',
                'type' => 'gateway',
                'instructions' => 'Pay securely with your PayPal account.',
                'account_details' => [],
                'is_active' => true,
            ],
            [
                'name' => 'Easypaisa',
                'type' => 'manual',
                'instructions' => 'Please send the amount to the following Easypaisa account and upload the screenshot.',
                'account_details' => [
                    'account_title' => 'School ERP Corp',
                    'account_number' => '0300-1234567',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Jazzcash',
                'type' => 'manual',
                'instructions' => 'Please send the amount to the following Jazzcash account and upload the screenshot.',
                'account_details' => [
                    'account_title' => 'School ERP Corp',
                    'account_number' => '0300-7654321',
                ],
                'is_active' => true,
            ],
            [
                'name' => 'Bank Transfer',
                'type' => 'manual',
                'instructions' => 'Please transfer the amount to the following Bank Account and upload the receipt.',
                'account_details' => [
                    'bank_name' => 'HBL',
                    'account_title' => 'School ERP Pvt Ltd',
                    'account_number' => '1234-5678-9012-3456',
                    'iban' => 'PK36HABB0012345678901234',
                ],
                'is_active' => true,
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(
                ['name' => $method['name']],
                $method
            );
        }
    }
}
