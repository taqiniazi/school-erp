<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Super Admin', ['except' => ['index']]);
    }

    public function index(Request $request)
    {
        $q = (string) $request->get('q', '');

        $query = Permission::query()->where('guard_name', 'web');
        if ($q !== '') {
            $query->where('name', 'like', '%' . $q . '%');
        }

        $permissions = $query->orderBy('name')->get();

        return view('permissions.index', compact('permissions', 'q'));
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions', 'name')->where(fn ($q) => $q->where('guard_name', 'web')),
            ],
        ]);

        Permission::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions', 'name')
                    ->ignore($permission->id)
                    ->where(fn ($q) => $q->where('guard_name', 'web')),
            ],
        ]);

        $permission->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
