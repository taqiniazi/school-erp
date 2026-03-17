<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::query()
            ->orderByDesc('is_active')
            ->orderBy('name')
            ->get();

        return view('discounts.index', [
            'discounts' => $discounts,
            'editingDiscount' => null,
        ]);
    }

    public function create()
    {
        return redirect()->route('discounts.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(['fixed', 'percentage'])],
            'value' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Discount::create([
            'name' => $data['name'],
            'type' => $data['type'],
            'value' => $data['value'],
            'description' => $data['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('discounts.index')->with('success', 'Discount created successfully.');
    }

    public function edit(Discount $discount)
    {
        $discounts = Discount::query()
            ->orderByDesc('is_active')
            ->orderBy('name')
            ->get();

        return view('discounts.index', [
            'discounts' => $discounts,
            'editingDiscount' => $discount,
        ]);
    }

    public function update(Request $request, Discount $discount)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', Rule::in(['fixed', 'percentage'])],
            'value' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $discount->update([
            'name' => $data['name'],
            'type' => $data['type'],
            'value' => $data['value'],
            'description' => $data['description'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('discounts.index')->with('success', 'Discount updated successfully.');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()->route('discounts.index')->with('success', 'Discount deleted successfully.');
    }
}
