<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $query = Subscription::with(['school', 'plan']);

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->whereHas('school', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $subscriptions = $query->latest()->get();

        return view('super-admin.subscriptions.index', compact('subscriptions'));
    }

    public function cancel(Subscription $subscription)
    {
        $subscription->update([
            'status' => 'canceled',
            'canceled_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Subscription canceled successfully.');
    }

    public function activate(Subscription $subscription)
    {
        $subscription->update([
            'status' => 'active',
            'canceled_at' => null,
            // Should we update dates? Maybe not, manual activation might just be status toggle.
            // Or maybe extend period? Let's just set status for now.
        ]);

        return redirect()->back()->with('success', 'Subscription activated successfully.');
    }
}
