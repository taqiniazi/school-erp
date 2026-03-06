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
        }])->paginate(20);
        return view('super-admin.schools.index', compact('schools'));
    }

    public function approve(School $school)
    {
        $school->is_active = true;
        $school->save();
        return redirect()->back();
    }

    public function suspend(School $school)
    {
        $school->is_active = false;
        $school->save();
        return redirect()->back();
    }
}
