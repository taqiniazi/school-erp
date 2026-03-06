<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::paginate(20);
        return view('super-admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('super-admin.plans.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:100', 'unique:plans,code'],
            'price' => ['required', 'numeric', 'min:0'],
            'billing_cycle' => ['required', 'in:monthly,yearly'],
            'features' => ['nullable'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        if ($request->filled('features')) {
            $data['features'] = json_decode($request->features, true) ?: [];
        }
        $data['is_active'] = $request->boolean('is_active');
        Plan::create($data);
        return redirect()->route('super-admin.plans.index');
    }

    public function edit(Plan $plan)
    {
        return view('super-admin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:100', 'unique:plans,code,'.$plan->id],
            'price' => ['required', 'numeric', 'min:0'],
            'billing_cycle' => ['required', 'in:monthly,yearly'],
            'features' => ['nullable'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        if ($request->filled('features')) {
            $data['features'] = json_decode($request->features, true) ?: [];
        }
        $data['is_active'] = $request->boolean('is_active');
        $plan->update($data);
        return redirect()->route('super-admin.plans.index');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('super-admin.plans.index');
    }
}
