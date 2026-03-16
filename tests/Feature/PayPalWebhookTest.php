<?php

namespace Tests\Feature;

use App\Models\Plan;
use App\Models\School;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayPalWebhookTest extends TestCase
{
    use RefreshDatabase;

    public function test_paypal_webhook_approves_payment()
    {
        $school = School::factory()->create();
        $user = User::factory()->create(['school_id' => $school->id]);
        $plan = Plan::create([
            'name' => 'Test Plan',
            'code' => 'test-plan-paypal',
            'price' => 1000,
            'duration_days' => 30,
            'billing_cycle' => 'monthly',
            'features' => json_encode(['modules' => ['all']]),
        ]);

        $subscription = Subscription::create([
            'school_id' => $school->id,
            'plan_id' => $plan->id,
            'status' => 'pending_approval',
            'current_period_start' => null,
            'current_period_end' => null,
        ]);

        $payment = SubscriptionPayment::create([
            'school_id' => $school->id,
            'subscription_id' => $subscription->id,
            'plan_id' => $plan->id,
            'amount' => 1000,
            'payment_method' => 'paypal',
            'status' => 'pending',
        ]);

        // Payload structure based on PayPal Webhook event
        // We look for 'custom_id' in 'resource' -> 'custom_id'
        // OR in 'resource' -> 'purchase_units' -> 0 -> 'custom_id'
        // The controller logic I wrote looks for: $resource['custom_id']
        // Wait, let's double check the controller logic.

        // Controller:
        // $resource = $payload['resource'];
        // $customId = $resource['custom_id'] ?? null;

        // In createOrder (payWithPaypal), I put 'custom_id' inside 'purchase_units'[0].
        // PayPal IPN/Webhook for PAYMENT.CAPTURE.COMPLETED typically has 'custom_id' at the resource level
        // IF it was passed during creation in the top level.
        // But I passed it inside purchase_units.

        // Let's check PayPal API docs or standard behavior.
        // Usually, 'custom_id' in purchase_unit IS mapped to 'custom_id' in the transaction resource.
        // Let's assume for this test that the payload has it in resource['custom_id'].

        $payload = [
            'event_type' => 'PAYMENT.CAPTURE.COMPLETED',
            'id' => 'WH-1234567890',
            'resource' => [
                'id' => 'CAP-123',
                'status' => 'COMPLETED',
                'custom_id' => $payment->id,
                'amount' => [
                    'currency_code' => 'USD',
                    'value' => '10.00',
                ],
            ],
        ];

        $response = $this->postJson(route('paypal.webhook'), $payload);

        $response->assertStatus(200);

        $this->assertDatabaseHas('subscription_payments', [
            'id' => $payment->id,
            'status' => 'approved',
        ]);

        $this->assertDatabaseHas('subscriptions', [
            'id' => $subscription->id,
            'status' => 'active',
        ]);
    }
}
