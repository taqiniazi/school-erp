<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use App\Notifications\SchoolAdminCredentialsNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::query()
            ->whereIn('id', function ($q) {
                $q->select('model_has_roles.model_id')
                    ->from('model_has_roles')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->where('model_has_roles.model_type', User::class)
                    ->where('roles.name', 'School Admin');
            })
            ->with('school')
            ->paginate(20);

        return view('super-admin.admin-users.index', compact('admins'));
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
                'is_active' => true,
            ]);

            $user = User::create([
                'name' => $data['admin_name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'password' => Hash::make($data['password']),
                'school_id' => $school->id,
            ]);

            app(PermissionRegistrar::class)->setPermissionsTeamId($school->id);
            $user->assignRole('School Admin');

            return [$school, $user];
        });

        $user->notify(new SchoolAdminCredentialsNotification(
            schoolName: $school->name,
            email: $user->email,
            password: $data['password'],
            loginUrl: route('login'),
        ));

        return redirect()->route('super-admin.admin-users.index');
    }
}
