<?php

namespace Tests\Feature;

use App\Models\Plan;
use App\Models\School;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Models\User;
use App\Notifications\PaymentStatusUpdated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class PaymentCallbackTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Create role if not exists
        if (! Role::where('name', 'School Admin')->exists()) {
            Role::create(['name' => 'School Admin', 'guard_name' => 'web']);
        }
    }

    private function createSetup($method, $txnRef, $amount, $cycle = 'monthly')
    {
        $plan = Plan::create([
            'name' => 'Test Plan',
            'code' => 'test-plan',
            'price' => $amount,
            'billing_cycle' => $cycle,
            'features' => [],
            'is_active' => true,
        ]);

        $school = School::factory()->create();
        $admin = User::factory()->create(['school_id' => $school->id]);
        $admin->assignRole('School Admin');

        $subscription = Subscription::create([
            'school_id' => $school->id,
            'plan_id' => $plan->id,
            'status' => 'pending',
            'current_period_start' => now(),
            'current_period_end' => $cycle === 'yearly' ? now()->addYear() : now()->addMonth(),
        ]);

        $payment = SubscriptionPayment::create([
            'school_id' => $school->id,
            'subscription_id' => $subscription->id,
            'plan_id' => $plan->id,
            'amount' => $amount,
            'payment_method' => $method,
            'transaction_reference' => $txnRef,
            'status' => 'pending',
        ]);

        return [$school, $admin, $subscription, $payment];
    }

    public function test_easypaisa_callback_approves_payment()
    {
        Notification::fake();
        [$school, $admin, $subscription, $payment] = $this->createSetup('easypaisa', 'TEST-TXN-12345', 1000);

        $payload = [
            'orderRefNumber' => 'TEST-TXN-12345',
            'transactionStatus' => '0000',
            'amount' => '1000',
        ];

        $response = $this->postJson(route('api.payment.callback.easypaisa'), $payload);

        $response->assertStatus(200)->assertJson(['status' => 'success']);
        $this->assertDatabaseHas('subscription_payments', ['id' => $payment->id, 'status' => 'approved']);
        $this->assertDatabaseHas('subscriptions', ['id' => $subscription->id, 'status' => 'active']);
        Notification::assertSentTo($admin, PaymentStatusUpdated::class);
    }

    public function test_jazzcash_callback_approves_payment()
    {
        Notification::fake();
        [$school, $admin, $subscription, $payment] = $this->createSetup('jazzcash', 'JAZZ-TXN-67890', 5000, 'yearly');

        $payload = [
            'pp_TxnRefNo' => 'JAZZ-TXN-67890',
            'pp_ResponseCode' => '000',
            'pp_Amount' => '500000',
        ];

        $response = $this->postJson(route('api.payment.callback.jazzcash'), $payload);

        $response->assertStatus(200)->assertJson(['status' => 'success']);
        $this->assertDatabaseHas('subscription_payments', ['id' => $payment->id, 'status' => 'approved']);
        Notification::assertSentTo($admin, PaymentStatusUpdated::class);
    }

    public function test_paypal_callback_approves_payment()
    {
        Notification::fake();
        [$school, $admin, $subscription, $payment] = $this->createSetup('paypal', 'PAYPAL-TXN-111', 2000);

        $payload = [
            'txn_id' => 'PAYPAL-TXN-111',
            'payment_status' => 'Completed',
        ];

        $response = $this->postJson(route('api.payment.callback.paypal'), $payload);

        $response->assertStatus(200)->assertJson(['status' => 'success']);
        $this->assertDatabaseHas('subscription_payments', ['id' => $payment->id, 'status' => 'approved']);
        Notification::assertSentTo($admin, PaymentStatusUpdated::class);
    }

    public function test_stripe_callback_approves_payment()
    {
        Notification::fake();
        [$school, $admin, $subscription, $payment] = $this->createSetup('stripe', 'pi_123456789', 3000);

        $payload = [
            'type' => 'payment_intent.succeeded',
            'data' => [
                'object' => [
                    'id' => 'pi_123456789',
                    'amount' => 300000,
                ],
            ],
        ];

        $response = $this->postJson(route('api.payment.callback.stripe'), $payload);

        $response->assertStatus(200)->assertJson(['status' => 'success']);
        $this->assertDatabaseHas('subscription_payments', ['id' => $payment->id, 'status' => 'approved']);
        Notification::assertSentTo($admin, PaymentStatusUpdated::class);
    }

    public function test_wise_callback_approves_payment()
    {
        Notification::fake();
        [$school, $admin, $subscription, $payment] = $this->createSetup('wise', 'WISE-TXN-999', 4000);

        $payload = [
            'event_type' => 'transfer.state-change',
            'data' => [
                'resource' => ['id' => 'WISE-TXN-999'],
                'current_state' => 'outgoing_payment_sent',
            ],
        ];

        $response = $this->postJson(route('api.payment.callback.wise'), $payload);

        $response->assertStatus(200)->assertJson(['status' => 'success']);
        $this->assertDatabaseHas('subscription_payments', ['id' => $payment->id, 'status' => 'approved']);
        Notification::assertSentTo($admin, PaymentStatusUpdated::class);
    }

    public function test_payoneer_callback_approves_payment()
    {
        Notification::fake();
        [$school, $admin, $subscription, $payment] = $this->createSetup('payoneer', 'PAYONEER-TXN-888', 2500);

        $payload = [
            'paymentId' => 'PAYONEER-TXN-888',
            'status' => 'Approved',
        ];

        $response = $this->postJson(route('api.payment.callback.payoneer'), $payload);

        $response->assertStatus(200)->assertJson(['status' => 'success']);
        $this->assertDatabaseHas('subscription_payments', ['id' => $payment->id, 'status' => 'approved']);
        Notification::assertSentTo($admin, PaymentStatusUpdated::class);
    }

    public function test_callback_fails_with_invalid_status()
    {
        Notification::fake();
        [$school, $admin, $subscription, $payment] = $this->createSetup('easypaisa', 'FAIL-TXN-12345', 1000);

        $payload = [
            'orderRefNumber' => 'FAIL-TXN-12345',
            'transactionStatus' => '0001', // Failed code
        ];

        $response = $this->postJson(route('api.payment.callback.easypaisa'), $payload);

        $response->assertStatus(200)->assertJson(['status' => 'failed']);
        $this->assertDatabaseHas('subscription_payments', ['id' => $payment->id, 'status' => 'pending']);
        Notification::assertNothingSent();
    }
}
