<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use App\Notifications\SchoolAdminCredentialsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\PermissionRegistrar;

class AdminUserController extends Controller
{
    public function index()
    {
        // Fetch users who have 'School Admin' role
        $admins = User::role('School Admin')->with('school')->latest()->get();

        return view('super-admin.admin-users.index', compact('admins'));
    }

    public function create()
    {
        return view('super-admin.admin-users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'school_name' => ['required', 'string', 'max:255'],
            'admin_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['required', 'string', 'max:50'],
            'password' => ['required', 'string', 'min:8'],
            'campus_count' => ['nullable', 'integer', 'min:1', 'max:10000'],
            'address' => ['required', 'string', 'max:500'],
        ]);

        [$school, $user] = DB::transaction(function () use ($data) {
            $schoolName = trim($data['school_name']);
            $baseSlug = str($schoolName)->slug()->value();
            $slug = $baseSlug;

            $suffix = 2;
            while (School::where('slug', $slug)->exists()) {
                $slug = $baseSlug.'-'.$suffix;
                $suffix++;
            }

            $school = School::create([
                'name' => $schoolName,
                'slug' => $slug,
                'campus_count' => $data['campus_count'] ?? null,
                'address' => $data['address'],
                'phone' => $data['phone_number'],
                'email' => $data['email'], // Added email to school
                'is_active' => true,
            ]);

            $user = User::create([
                'name' => $data['admin_name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'password' => Hash::make($data['password']),
                'school_id' => $school->id,
            ]);

            // Ensure we are setting permissions for this specific team/school
            app(PermissionRegistrar::class)->setPermissionsTeamId($school->id);
            $user->assignRole('School Admin');

            return [$school, $user];
        });

        // Send credentials via notification
        try {
            $user->notify(new SchoolAdminCredentialsNotification(
                schoolName: $school->name,
                email: $user->email,
                password: $data['password'],
                loginUrl: route('login'),
            ));
        } catch (\Exception $e) {
            // Log error but don't fail the request
            // Log::error('Failed to send admin credentials: ' . $e->getMessage());
        }

        return redirect()->route('super-admin.admin-users.index')->with('success', 'School Admin created successfully.');
    }

    public function edit(User $adminUser)
    {
        // Ensure the user is actually a School Admin
        if (! $adminUser->hasRole('School Admin')) {
            return redirect()->route('super-admin.admin-users.index')->with('error', 'User is not a School Admin.');
        }

        $adminUser->load('school');

        return view('super-admin.admin-users.edit', compact('adminUser'));
    }

    public function update(Request $request, User $adminUser)
    {
        $data = $request->validate([
            'school_name' => ['required', 'string', 'max:255'],
            'admin_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($adminUser->id)],
            'phone_number' => ['required', 'string', 'max:50'],
            'campus_count' => ['nullable', 'integer', 'min:1'],
            'address' => ['required', 'string', 'max:500'],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        DB::transaction(function () use ($data, $adminUser) {
            // Update School
            if ($adminUser->school) {
                $adminUser->school->update([
                    'name' => $data['school_name'],
                    'campus_count' => $data['campus_count'] ?? null,
                    'address' => $data['address'],
                    'phone' => $data['phone_number'],
                    'email' => $data['email'],
                ]);
            }

            // Update User
            $userData = [
                'name' => $data['admin_name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
            ];

            if (! empty($data['password'])) {
                $userData['password'] = Hash::make($data['password']);
            }

            $adminUser->update($userData);
        });

        return redirect()->route('super-admin.admin-users.index')->with('success', 'School Admin updated successfully.');
    }

    public function destroy(User $adminUser)
    {
        // Prevent deleting yourself
        if (auth()->id() === $adminUser->id) {
            return redirect()->back()->with('error', 'You cannot delete yourself.');
        }

        DB::transaction(function () use ($adminUser) {
            // Delete School (and cascading delete users/students etc if set up, otherwise just soft delete or keep)
            // For now, we'll just delete the user and their school.

            $school = $adminUser->school;

            $adminUser->delete();

            if ($school) {
                // Ideally, we should soft delete or deactivate the school instead of hard delete to preserve data integrity
                // But per requirement "delete", we will delete the school record.
                // In a real app, this should be a soft delete.
                $school->delete();
            }
        });

        return redirect()->route('super-admin.admin-users.index')->with('success', 'School Admin and School deleted successfully.');
    }
}
