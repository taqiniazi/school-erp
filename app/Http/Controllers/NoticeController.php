<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use App\Models\User;
use App\Notifications\NewNoticeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NoticeController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:Super Admin|School Admin|Teacher', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole(['Super Admin', 'School Admin', 'Teacher'])) {
            $notices = Notice::with('creator')->latest()->get();
        } else {
            // Students and Parents see general notices and role-specific ones
            $userRoles = $user->getRoleNames(); // Collection of role names
            $rolesToCheck = $userRoles->push('all')->toArray();

            $notices = Notice::with('creator')
                ->whereIn('audience_role', $rolesToCheck)
                ->latest()
                ->get();
        }

        return view('communication.notices.index', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('communication.notices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,urgent,event',
            'audience_role' => 'required|string', // e.g., 'all', 'Student', 'Parent', 'Teacher'
        ]);

        $notice = Notice::create([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'audience_role' => $request->audience_role,
            'published_at' => now(),
            'created_by' => Auth::id(),
        ]);

        // Send SMS/Email integration
        if ($request->has('send_notification')) {
            $audience = $request->audience_role;
            $users = collect();

            if ($audience === 'all') {
                $users = User::all();
            } else {
                $users = User::role($audience)->get();
            }

            // Filter out the creator if they are in the audience
            $users = $users->reject(function ($user) {
                return $user->id === Auth::id();
            });

            if ($users->isNotEmpty()) {
                Notification::send($users, new NewNoticeNotification($notice));
            }
        }

        return redirect()->route('communication.notices.index')->with('success', 'Notice published successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Notice $notice)
    {
        return view('communication.notices.show', compact('notice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notice $notice)
    {
        return view('communication.notices.edit', compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notice $notice)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,urgent,event',
            'audience_role' => 'required|string',
        ]);

        $notice->update($request->all());

        return redirect()->route('communication.notices.index')->with('success', 'Notice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notice $notice)
    {
        $notice->delete();

        return redirect()->route('communication.notices.index')->with('success', 'Notice deleted successfully.');
    }
}
