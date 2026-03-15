<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::get();
        return view('super-admin.plans.index', compact('plans'));
    }

    public function create()
    {
        $modules = $this->getAvailableModules();
        return view('super-admin.plans.create', compact('modules'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:100', 'unique:plans,code'],
            'price' => ['required', 'numeric', 'min:0'],
            'billing_cycle' => ['required', 'in:monthly,yearly'],
            'max_students' => ['nullable', 'integer', 'min:1'],
            'max_teachers' => ['nullable', 'integer', 'min:1'],
            'max_campuses' => ['nullable', 'integer', 'min:1'],
            'storage_limit_mb' => ['nullable', 'integer', 'min:1'],
            'features' => ['nullable', 'string'],
            'allowed_modules' => ['nullable', 'array'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->filled('features')) {
             // Split by newline and filter empty lines
             $features = preg_split('/\r\n|\r|\n/', $request->features);
             $data['features'] = array_values(array_filter(array_map('trim', $features)));
        } else {
            $data['features'] = [];
        }
        
        $data['allowed_modules'] = $request->input('allowed_modules', []);
        $data['is_active'] = $request->boolean('is_active');
        
        Plan::create($data);

        return redirect()->route('super-admin.plans.index')->with('success', 'Plan created successfully.');
    }

    public function edit(Plan $plan)
    {
        $modules = $this->getAvailableModules();
        return view('super-admin.plans.edit', compact('plan', 'modules'));
    }

    public function update(Request $request, Plan $plan)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:100', 'unique:plans,code,'.$plan->id],
            'price' => ['required', 'numeric', 'min:0'],
            'billing_cycle' => ['required', 'in:monthly,yearly'],
            'max_students' => ['nullable', 'integer', 'min:1'],
            'max_teachers' => ['nullable', 'integer', 'min:1'],
            'max_campuses' => ['nullable', 'integer', 'min:1'],
            'storage_limit_mb' => ['nullable', 'integer', 'min:1'],
            'features' => ['nullable', 'string'],
            'allowed_modules' => ['nullable', 'array'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->filled('features')) {
             // Split by newline and filter empty lines
             $features = preg_split('/\r\n|\r|\n/', $request->features);
             $data['features'] = array_values(array_filter(array_map('trim', $features)));
        } else {
            $data['features'] = [];
        }

        $data['allowed_modules'] = $request->input('allowed_modules', []);
        $data['is_active'] = $request->boolean('is_active');
        
        $plan->update($data);

        return redirect()->route('super-admin.plans.index')->with('success', 'Plan updated successfully.');
    }

    public function destroy(Plan $plan)
    {
        // Check for subscriptions before deleting? 
        // For now, just delete (or soft delete if model supports it, but migration didn't show soft deletes)
        $plan->delete();
        return redirect()->route('super-admin.plans.index')->with('success', 'Plan deleted successfully.');
    }

    private function getAvailableModules()
    {
        return [
            'admissions',
            'students',
            'teachers',
            'academics',
            'timetable',
            'attendance',
            'examinations',
            'reports',
            'library',
            'transport',
            'hostel',
            'communication',
            'fees',
            'accounts',
            'inventory',
        ];
    }
}
