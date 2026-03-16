<?php

namespace App\Http\Controllers;

use App\Models\EmailSmsLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EmailSmsController extends Controller
{
    public function index()
    {
        $logs = EmailSmsLog::orderByDesc('created_at')->limit(200)->get();

        return view('communication.email-sms.index', compact('logs'));
    }

    public function create()
    {
        return view('communication.email-sms.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'channel' => ['required', 'in:email'],
            'recipient_group' => ['required', 'in:students,teachers,parents,all_users,custom'],
            'custom_emails' => ['nullable', 'string', 'max:5000'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:10000'],
        ]);

        $emails = match ($data['recipient_group']) {
            'students' => User::role('Student')->whereNotNull('email')->pluck('email'),
            'teachers' => User::role('Teacher')->whereNotNull('email')->pluck('email'),
            'parents' => User::role('Parent')->whereNotNull('email')->pluck('email'),
            'all_users' => User::whereNotNull('email')->pluck('email'),
            default => collect(),
        };

        if ($data['recipient_group'] === 'custom') {
            $raw = (string) ($data['custom_emails'] ?? '');
            $parts = preg_split('/[\s,;]+/', $raw, -1, PREG_SPLIT_NO_EMPTY) ?: [];
            $emails = collect($parts);
        }

        $emails = $emails
            ->map(fn ($email) => trim((string) $email))
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values();

        if ($emails->isEmpty()) {
            return redirect()->back()->withErrors(['recipients' => 'No valid recipients found.'])->withInput();
        }

        $status = 'sent';
        $errorMessage = null;

        try {
            foreach ($emails->chunk(50) as $chunk) {
                foreach ($chunk as $email) {
                    Mail::raw($data['message'], function ($message) use ($email, $data) {
                        $message->to($email)->subject($data['subject']);
                    });
                }
            }
        } catch (\Throwable $e) {
            $status = 'failed';
            $errorMessage = mb_substr($e->getMessage(), 0, 1000);
        }

        $log = EmailSmsLog::create([
            'channel' => 'email',
            'recipient_group' => $data['recipient_group'],
            'recipients' => $emails->all(),
            'subject' => $data['subject'],
            'message' => $data['message'],
            'status' => $status,
            'error_message' => $errorMessage,
            'sent_at' => now(),
            'created_by' => Auth::id(),
        ]);

        if ($status !== 'sent') {
            return redirect()->route('communication.email-sms.show', $log)->with('error', 'Message queued in log but sending failed. Check mail configuration.');
        }

        return redirect()->route('communication.email-sms.show', $log)->with('success', 'Email sent.');
    }

    public function show(EmailSmsLog $emailSmsLog)
    {
        return view('communication.email-sms.show', ['log' => $emailSmsLog]);
    }
}
