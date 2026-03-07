<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPayment;
use App\Models\User;
use App\Notifications\PaymentStatusUpdated;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class PaymentCallbackController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }
    /**
     * Handle Easypaisa IPN Callback
     */
    public function easypaisa(Request $request)
    {
        Log::info('Easypaisa IPN Received', $request->all());

        // Validate Easypaisa Signature (Mock implementation)
        // In production, you would verify the hash using your merchant key
        // $hash = $request->input('hash');
        // if (!$this->verifyEasypaisaHash($request->all(), $hash)) {
        //     return response()->json(['status' => 'error', 'message' => 'Invalid Signature'], 400);
        // }

        $orderRef = $request->input('orderRefNumber');
        $status = $request->input('transactionStatus'); // 0000 = Success

        if ($status === '0000') {
            $this->approvePayment($orderRef, 'easypaisa', $request->all());
            return response()->json(['status' => 'success', 'message' => 'Payment Processed']);
        }

        return response()->json(['status' => 'failed', 'message' => 'Transaction Failed']);
    }

    /**
     * Handle Jazzcash IPN Callback
     */
    public function jazzcash(Request $request)
    {
        Log::info('Jazzcash IPN Received', $request->all());

        // Validate Jazzcash Secure Hash
        // $secureHash = $request->input('pp_SecureHash');
        // if (!$this->verifyJazzcashHash($request->all(), $secureHash)) {
        //     return response()->json(['status' => 'error', 'message' => 'Invalid Signature'], 400);
        // }

        $txnRef = $request->input('pp_TxnRefNo');
        $responseCode = $request->input('pp_ResponseCode'); // 000 = Success

        if ($responseCode === '000') {
            $this->approvePayment($txnRef, 'jazzcash', $request->all());
            return response()->json(['status' => 'success', 'message' => 'Payment Processed']);
        }

        return response()->json(['status' => 'failed', 'message' => 'Transaction Failed']);
    }

    /**
     * Handle PayPal IPN/Webhook Callback
     */
    public function paypal(Request $request)
    {
        Log::info('PayPal IPN Received', $request->all());

        // Validate PayPal IPN (Mock)
        // In production, verify with PayPal's IPN simulator or SDK
        
        $paymentStatus = $request->input('payment_status'); // 'Completed'
        $txnId = $request->input('txn_id');
        
        // Sometimes custom_id or invoice field holds the internal reference
        // $customId = $request->input('custom'); 

        if ($paymentStatus === 'Completed') {
            $this->approvePayment($txnId, 'paypal', $request->all());
            return response()->json(['status' => 'success', 'message' => 'Payment Processed']);
        }

        return response()->json(['status' => 'failed', 'message' => 'Transaction not completed']);
    }

    /**
     * Handle Stripe Webhook
     */
    public function stripe(Request $request)
    {
        Log::info('Stripe Webhook Received', $request->all());

        // Validate Stripe Signature
        // $sig_header = $request->header('Stripe-Signature');
        // Verify using Stripe SDK...

        $payload = $request->all();
        $type = $payload['type'] ?? '';

        if ($type === 'checkout.session.completed' || $type === 'payment_intent.succeeded') {
            $data = $payload['data']['object'];
            
            // Assuming we store transaction_reference as payment_intent id or client_reference_id
            $txnId = $data['id'] ?? $data['payment_intent'] ?? null;
            
            if ($txnId) {
                $this->approvePayment($txnId, 'stripe', $payload);
                return response()->json(['status' => 'success', 'message' => 'Payment Processed']);
            }
        }

        return response()->json(['status' => 'ignored', 'message' => 'Event not handled']);
    }

    /**
     * Handle Wise Webhook
     */
    public function wise(Request $request)
    {
        Log::info('Wise Webhook Received', $request->all());

        // Verify Signature using X-Signature-SHA256 header and public key

        $data = $request->input('data');
        $eventType = $request->input('event_type'); // e.g., 'transfer.state-change'

        if (isset($data['current_state']) && $data['current_state'] === 'outgoing_payment_sent') {
            $resourceId = $data['resource']['id']; // Transfer ID
            
            $this->approvePayment($resourceId, 'wise', $request->all());
            return response()->json(['status' => 'success', 'message' => 'Payment Processed']);
        }

        return response()->json(['status' => 'ignored', 'message' => 'Event not handled']);
    }

    /**
     * Handle Payoneer Callback
     */
    public function payoneer(Request $request)
    {
        Log::info('Payoneer Callback Received', $request->all());

        // Authenticate request using Basic Auth or shared secret

        $paymentId = $request->input('paymentId');
        $status = $request->input('status'); // 'Approved' or 'Completed' (check docs)
        $clientReference = $request->input('client_reference_id'); // If sent during checkout

        // Using paymentId as transaction reference
        if ($status === 'Approved' || $status === 'Completed') {
            $this->approvePayment($paymentId, 'payoneer', $request->all());
            return response()->json(['status' => 'success', 'message' => 'Payment Processed']);
        }

        return response()->json(['status' => 'failed', 'message' => 'Transaction not approved']);
    }

    private function approvePayment($transactionReference, $gateway, $data)
    {
        $payment = SubscriptionPayment::where('transaction_reference', $transactionReference)
            ->where('status', 'pending')
            ->first();

        if (!$payment) {
            Log::warning("Payment not found or already processed: $transactionReference");
            return;
        }

        $note = "Auto-approved via $gateway IPN. " . json_encode($data);
        $this->paymentService->approvePayment($payment, $note);

        // Send Notification
        $admins = User::role('School Admin')->where('school_id', $payment->school_id)->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new PaymentStatusUpdated($payment));
        }
    }
}
