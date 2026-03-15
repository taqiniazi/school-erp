<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $methods = PaymentMethod::latest()->get();
        return view('super-admin.payment-methods.index', compact('methods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('super-admin.payment-methods.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $accountDetails = [];
        if ($request->has('account_details_keys') && $request->has('account_details_values')) {
            $keys = $request->account_details_keys;
            $values = $request->account_details_values;
            foreach ($keys as $index => $key) {
                if (!empty($key) && !empty($values[$index])) {
                    $accountDetails[$key] = $values[$index];
                }
            }
        }
        $request->merge(['account_details' => $accountDetails]);

        $request->validate([
            'name' => 'required|string|max:255|unique:payment_methods,name',
            'type' => 'required|in:manual,gateway',
            'instructions' => 'required_if:type,manual|nullable|string',
            'account_details' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        PaymentMethod::create([
            'name' => $request->name,
            'type' => $request->type,
            'instructions' => $request->instructions,
            'account_details' => $request->account_details,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('super-admin.payment-methods.index')
            ->with('success', 'Payment method created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $paymentMethod)
    {
        return view('super-admin.payment-methods.edit', compact('paymentMethod'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $accountDetails = [];
        if ($request->has('account_details_keys') && $request->has('account_details_values')) {
            $keys = $request->account_details_keys;
            $values = $request->account_details_values;
            foreach ($keys as $index => $key) {
                if (!empty($key) && !empty($values[$index])) {
                    $accountDetails[$key] = $values[$index];
                }
            }
        }
        $request->merge(['account_details' => $accountDetails]);

        $request->validate([
            'name' => 'required|string|max:255|unique:payment_methods,name,' . $paymentMethod->id,
            'type' => 'required|in:manual,gateway',
            'instructions' => 'required_if:type,manual|nullable|string',
            'account_details' => 'nullable|array',
            'is_active' => 'boolean',
        ]);

        $paymentMethod->update([
            'name' => $request->name,
            'type' => $request->type,
            'instructions' => $request->instructions,
            'account_details' => $request->account_details,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('super-admin.payment-methods.index')
            ->with('success', 'Payment method updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return redirect()->route('super-admin.payment-methods.index')
            ->with('success', 'Payment method deleted successfully.');
    }
}
