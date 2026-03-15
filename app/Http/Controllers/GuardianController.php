<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class GuardianController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->get('q', ''));

        $query = User::role('Parent')
            ->withCount('students')
            ->orderBy('name');

        if ($q !== '') {
            $query->where(function ($w) use ($q) {
                $w->where('name', 'like', '%'.$q.'%')
                    ->orWhere('email', 'like', '%'.$q.'%')
                    ->orWhere('phone_number', 'like', '%'.$q.'%');
            });
        }

        $guardians = $query->get();

        return view('guardians.index', compact('guardians', 'q'));
    }

    public function show(User $guardian)
    {
        abort_unless($guardian->hasRole('Parent'), 404);

        $guardian->load([
            'students' => function ($q) {
                $q->with(['schoolClass', 'section'])->orderBy('first_name')->orderBy('last_name');
            },
        ]);

        return view('guardians.show', compact('guardian'));
    }
}
