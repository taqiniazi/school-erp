<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource (Inbox).
     */
    public function index()
    {
        $messages = Message::with('sender')
            ->where('recipient_id', Auth::id())
            ->latest()
            ->get();

        return view('communication.messages.index', compact('messages'));
    }

    /**
     * Display sent messages.
     */
    public function sent()
    {
        $messages = Message::with('recipient')
            ->where('sender_id', Auth::id())
            ->latest()
            ->get();

        return view('communication.messages.sent', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $recipients = collect();

        if ($user->hasRole(['Super Admin', 'School Admin'])) {
            $recipients = User::where('id', '!=', $user->id)->get();
        } elseif ($user->hasRole('Teacher')) {
            // In a real app, filter by students' parents.
            // For now, allow messaging all parents and admins.
            $recipients = User::role(['Parent', 'School Admin', 'Super Admin'])->where('id', '!=', $user->id)->get();
        } elseif ($user->hasRole('Parent')) {
            // Allow messaging teachers and admins.
            $recipients = User::role(['Teacher', 'School Admin', 'Super Admin'])->where('id', '!=', $user->id)->get();
        } else {
            // Students? Maybe message Teachers.
            $recipients = User::role('Teacher')->where('id', '!=', $user->id)->get();
        }

        return view('communication.messages.create', compact('recipients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'recipient_id' => $request->recipient_id,
            'subject' => $request->subject,
            'content' => $request->content,
        ]);

        return redirect()->route('communication.messages.index')->with('success', 'Message sent successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        // Ensure user is participant
        if ($message->recipient_id !== Auth::id() && $message->sender_id !== Auth::id()) {
            abort(403);
        }

        // Mark as read if recipient
        if ($message->recipient_id === Auth::id() && is_null($message->read_at)) {
            $message->update(['read_at' => now()]);
        }

        return view('communication.messages.show', compact('message'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        if ($message->recipient_id !== Auth::id() && $message->sender_id !== Auth::id()) {
            abort(403);
        }

        $message->delete();

        return redirect()->back()->with('success', 'Message deleted.');
    }
}
