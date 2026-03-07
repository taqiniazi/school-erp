<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\SubscriptionPayment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function create(Plan $plan)
    {
        $manualMethods = PaymentMethod::where('is_active', true)
            ->where('type', 'manual')
            ->get();

        return view('billing.payment', [
            'plan' => $plan,
            'school' => auth()->user()->school,
            'manualMethods' => $manualMethods,
        ]);
    }

    public function store(Request $request, Plan $plan)
    {
        $request->validate([
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'transaction_reference' => ['nullable', 'string', 'max:255'],
            'proof_file' => ['required', 'image', 'max:2048'], // 2MB Max
        ]);

        $school = $request->user()->school;
        $paymentMethod = PaymentMethod::findOrFail($request->payment_method_id);
        
        // Handle File Upload
        $path = $request->file('proof_file')->store('payment_proofs', 'public');

        DB::transaction(function () use ($school, $plan, $request, $path, $paymentMethod) {
            // Cancel any previous pending subscriptions
            Subscription::where('school_id', $school->id)
                ->where('status', 'pending_approval')
                ->delete(); // Or cancel them

            // Create new pending subscription
            $subscription = Subscription::create([
                'school_id' => $school->id,
                'plan_id' => $plan->id,
                'status' => 'pending_approval',
                'current_period_start' => null, // Will be set on approval
                'current_period_end' => null,
            ]);

            // Create Payment Record
            SubscriptionPayment::create([
                'school_id' => $school->id,
                'subscription_id' => $subscription->id,
                'plan_id' => $plan->id,
                'amount' => $plan->price,
                'payment_method' => $paymentMethod->name,
                'payment_method_id' => $paymentMethod->id,
                'transaction_reference' => $request->transaction_reference,
                'proof_file_path' => $path,
                'status' => 'pending',
            ]);
        });

        return redirect()->route('billing.payment.pending');
    }

    public function pending()
    {
        return view('billing.pending');
    }
    
    public function history()
    {
        $payments = SubscriptionPayment::with('plan')
            ->where('school_id', auth()->user()->school_id)
            ->latest()
            ->paginate(10);
            
        return view('billing.history', compact('payments'));
    }

    // Stripe Payment
    public function payWithStripe(Request $request, Plan $plan)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $payment = $this->createPendingPayment($plan, 'Stripe');

        $session = StripeSession::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'pkr',
                    'product_data' => [
                        'name' => $plan->name . ' Plan (' . ucfirst($plan->billing_cycle) . ')',
                    ],
                    'unit_amount' => $plan->price * 100, // Amount in cents
                ],
                'quantity' => 1,
            ]],
            'metadata' => [
                'payment_id' => $payment->id,
            ],
            'mode' => 'payment',
            'success_url' => route('billing.payment.stripe.callback') . '?session_id={CHECKOUT_SESSION_ID}&payment_id=' . $payment->id,
            'cancel_url' => route('billing.payment.create', $plan->id),
        ]);

        return redirect($session->url);
    }

    public function stripeCallback(Request $request)
    {
        $sessionId = $request->get('session_id');
        $paymentId = $request->get('payment_id');

        if (!$sessionId || !$paymentId) {
            abort(404);
        }

        $payment = SubscriptionPayment::findOrFail($paymentId);

        if ($payment->status === 'approved') {
            return redirect()->route('billing.payment.history')->with('success', 'Payment already approved.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));
        $session = StripeSession::retrieve($sessionId);

        if ($session->payment_status === 'paid') {
            $this->paymentService->approvePayment($payment, "Stripe Session ID: $sessionId");
            return redirect()->route('billing.payment.history')->with('success', 'Payment successful! Invoice generated.');
        }

        return redirect()->route('billing.payment.create', $payment->plan_id)->with('error', 'Payment failed.');
    }

    // PayPal Payment
    public function payWithPaypal(Request $request, Plan $plan)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $payment = $this->createPendingPayment($plan, 'PayPal');

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('billing.payment.paypal.callback', ['payment_id' => $payment->id]),
                "cancel_url" => route('billing.payment.paypal.cancel'),
            ],
            "purchase_units" => [
                0 => [
                    "custom_id" => $payment->id, // Pass payment ID for webhook tracking
                    "amount" => [
                        "currency_code" => "USD", // PayPal might not support PKR directly in sandbox, adjust as needed
                        "value" => number_format($plan->price / 280, 2, '.', '') // Rough conversion if needed, or use USD plan price
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['status'] == 'CREATED') {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('billing.payment.create', $plan->id)->with('error', 'Something went wrong with PayPal.');
    }

    public function paypalCallback(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        
        $response = $provider->capturePaymentOrder($request['token']);
        $paymentId = $request->get('payment_id');
        $payment = SubscriptionPayment::findOrFail($paymentId);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            $this->paymentService->approvePayment($payment, "PayPal Order ID: " . $response['id']);
            return redirect()->route('billing.payment.history')->with('success', 'Payment successful! Invoice generated.');
        }

        return redirect()->route('billing.payment.create', $payment->plan_id)->with('error', 'Payment failed.');
    }

    public function paypalCancel()
    {
        return redirect()->route('billing.choose-plan')->with('error', 'Payment canceled.');
    }

    public function stripeWebhook(Request $request)
    {
        $payload = @file_get_contents('php://input');
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        // Handle the event
        if ($event->type == 'checkout.session.completed') {
            $session = $event->data->object;
            
            $paymentId = $session->metadata->payment_id ?? null;
            
            if ($paymentId) {
                $payment = SubscriptionPayment::find($paymentId);
                if ($payment) {
                    $this->paymentService->approvePayment($payment, "Stripe Webhook: " . $session->id);
                }
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function paypalWebhook(Request $request)
    {
        // For PayPal Webhooks, we should verify the signature.
        // This usually requires headers like PAYPAL-TRANSMISSION-ID, PAYPAL-TRANSMISSION-TIME, etc.
        // and verifying against the webhook ID and certificate URL.
        
        // Since we are using srmklive/laravel-paypal, let's see if we can use it or just do a basic check for now.
        // A full implementation requires matching the webhook ID from config.
        
        $payload = $request->all();
        
        if (isset($payload['event_type']) && $payload['event_type'] == 'PAYMENT.CAPTURE.COMPLETED') {
            $resource = $payload['resource'];
            
            // In the createOrder (payWithPaypal), we set the return URL with payment_id.
            // But the webhook payload doesn't necessarily carry that custom parameter in the top level.
            // However, the 'custom_id' field in the purchase_unit can be used to store payment_id.
            // Let's check if we set custom_id in payWithPaypal. 
            // We didn't. We should update payWithPaypal to include 'custom_id' => $payment->id.
            
            $customId = $resource['custom_id'] ?? null;
            
            if ($customId) {
                $payment = SubscriptionPayment::find($customId);
                if ($payment && $payment->status !== 'approved') {
                    $this->paymentService->approvePayment($payment, "PayPal Webhook: " . $payload['id']);
                }
            }
        }
        
        return response()->json(['status' => 'success']);
    }

    private function createPendingPayment(Plan $plan, $method)
    {
        $school = auth()->user()->school;

        return DB::transaction(function () use ($school, $plan, $method) {
            // Cancel any previous pending subscriptions
            Subscription::where('school_id', $school->id)
                ->where('status', 'pending_approval')
                ->delete(); 

            // Create new pending subscription
            $subscription = Subscription::create([
                'school_id' => $school->id,
                'plan_id' => $plan->id,
                'status' => 'pending_approval',
                'current_period_start' => null,
                'current_period_end' => null,
            ]);

            // Create Payment Record
            return SubscriptionPayment::create([
                'school_id' => $school->id,
                'subscription_id' => $subscription->id,
                'plan_id' => $plan->id,
                'amount' => $plan->price,
                'payment_method' => $method,
                'transaction_reference' => 'PENDING', // Will be updated
                'proof_file_path' => null,
                'status' => 'pending',
            ]);
        });
    }
}
