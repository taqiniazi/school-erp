<?php

namespace App\Http\Controllers;

use App\Models\InventorySupplier;
use App\Services\SchoolContext;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class InventorySupplierController extends Controller
{
    public function index()
    {
        $suppliers = InventorySupplier::orderBy('name')->get();

        return view('inventory.suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('inventory.suppliers.create');
    }

    public function store(Request $request)
    {
        $schoolId = SchoolContext::getSchoolId();
        $nameRule = Rule::unique('inventory_suppliers', 'name');
        if ($schoolId) {
            $nameRule = $nameRule->where(fn ($q) => $q->where('school_id', $schoolId));
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', $nameRule],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        InventorySupplier::create([
            'name' => $data['name'],
            'contact_person' => $data['contact_person'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);

        return redirect()->route('inventory.suppliers.index')->with('success', 'Supplier created.');
    }

    public function edit(InventorySupplier $supplier)
    {
        return view('inventory.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, InventorySupplier $supplier)
    {
        $schoolId = SchoolContext::getSchoolId();
        $nameRule = Rule::unique('inventory_suppliers', 'name')->ignore($supplier->id);
        if ($schoolId) {
            $nameRule = $nameRule->where(fn ($q) => $q->where('school_id', $schoolId));
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', $nameRule],
            'contact_person' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $supplier->update([
            'name' => $data['name'],
            'contact_person' => $data['contact_person'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'is_active' => (bool) ($data['is_active'] ?? true),
        ]);

        return redirect()->route('inventory.suppliers.index')->with('success', 'Supplier updated.');
    }

    public function destroy(InventorySupplier $supplier)
    {
        $supplier->delete();

        return redirect()->route('inventory.suppliers.index')->with('success', 'Supplier deleted.');
    }
}
