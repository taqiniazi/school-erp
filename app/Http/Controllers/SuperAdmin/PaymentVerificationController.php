<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPayment;
use App\Models\User;
use App\Notifications\PaymentStatusUpdated;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class PaymentVerificationController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index()
    {
        $payments = SubscriptionPayment::with(['school', 'plan', 'paymentMethod'])
            ->latest()
            ->get();

        return view('super-admin.payments.index', compact('payments'));
    }

    public function update(Request $request, SubscriptionPayment $payment)
    {
        $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'admin_note' => ['nullable', 'string'],
        ]);

        if ($request->status === 'approved') {
            $this->paymentService->approvePayment($payment, $request->admin_note);
        } elseif ($request->status === 'rejected') {
            DB::transaction(function () use ($request, $payment) {
                $payment->update([
                    'status' => 'rejected',
                    'admin_note' => $request->admin_note,
                ]);
                $payment->subscription->update(['status' => 'canceled']);
            });
        }

        // Send Notification
        $admins = User::role('School Admin')->where('school_id', $payment->school_id)->get();
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new PaymentStatusUpdated($payment));
        }

        return redirect()->back()->with('success', 'Payment status updated successfully.');
    }
}
