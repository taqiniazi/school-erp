<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $admins = User::role('School Admin')->with('school')->paginate(20);
        $schools = School::orderBy('name')->get();
        return view('super-admin.admin-users.index', compact('admins', 'schools'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'school_id' => ['required', 'exists:schools,id'],
        ]);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $user->school_id = $data['school_id'];
        $user->save();
        $user->assignRole('School Admin');
        return redirect()->back();
    }
}
