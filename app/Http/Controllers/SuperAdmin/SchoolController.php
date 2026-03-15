<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\School;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::with(['subscriptions' => function ($q) {
            $q->latest();
        }])
        ->withCount(['students', 'teachers', 'campuses'])
        ->get();
        
        return view('super-admin.schools.index', compact('schools'));
    }

    public function activate(School $school)
    {
        $school->update(['is_active' => true]);
        return redirect()->back()->with('success', 'School activated successfully.');
    }

    public function deactivate(School $school)
    {
        $school->update(['is_active' => false]);
        return redirect()->back()->with('success', 'School deactivated successfully.');
    }
}
