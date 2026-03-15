<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('guard_name', 'web')->latest()->get();
        return view('super-admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::query()
            ->where('guard_name', 'web')
            ->get()
            ->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });
        return view('super-admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role = Role::create(['name' => $request->name, 'guard_name' => 'web']);

        $permissionIds = array_map('intval', $request->input('permissions', []));
        if ($permissionIds !== []) {
            $permissions = Permission::query()
                ->where('guard_name', 'web')
                ->whereIn('id', $permissionIds)
                ->get();

            $role->syncPermissions($permissions);
        }

        return redirect()->route('super-admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::query()
            ->where('guard_name', 'web')
            ->get()
            ->groupBy(function ($permission) {
            return explode('.', $permission->name)[0];
        });
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('super-admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role->id)],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $role->update(['name' => $request->name]);

        $permissionIds = array_map('intval', $request->input('permissions', []));
        $permissions = Permission::query()
            ->where('guard_name', 'web')
            ->whereIn('id', $permissionIds)
            ->get();

        $role->syncPermissions($permissions);

        return redirect()->route('super-admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        if (in_array($role->name, ['Super Admin', 'School Admin', 'Teacher', 'Student', 'Parent'])) {
            return redirect()->back()->with('error', 'Cannot delete system roles.');
        }

        $role->delete();
        return redirect()->route('super-admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
