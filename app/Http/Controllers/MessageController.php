<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    private const GROUPS = [
        'group:staff',
        'group:teachers',
        'group:students',
    ];

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
            $recipients = User::with('roles')->where('id', '!=', $user->id)->orderBy('name')->get();
        } elseif ($user->hasRole('Teacher')) {
            // In a real app, filter by students' parents.
            // For now, allow messaging all parents and admins.
            $recipients = User::with('roles')->role(['Parent', 'School Admin', 'Super Admin'])->where('id', '!=', $user->id)->orderBy('name')->get();
        } elseif ($user->hasRole('Parent')) {
            // Allow messaging teachers and admins.
            $recipients = User::with('roles')->role(['Teacher', 'School Admin', 'Super Admin'])->where('id', '!=', $user->id)->orderBy('name')->get();
        } else {
            // Students? Maybe message Teachers.
            $recipients = User::with('roles')->role('Teacher')->where('id', '!=', $user->id)->orderBy('name')->get();
        }

        return view('communication.messages.create', compact('recipients'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'recipient_id' => ['required', 'string'],
            'subject' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
        ]);

        $senderId = Auth::id();
        $recipientKey = $data['recipient_id'];
        $content = $this->sanitizeMessageHtml($data['content']);

        if (in_array($recipientKey, self::GROUPS, true)) {
            $user = Auth::user();
            if (! $user->hasRole(['Super Admin', 'School Admin'])) {
                abort(403);
            }

            $recipients = $this->getGroupRecipients($recipientKey, $senderId);
            if ($recipients->isEmpty()) {
                return redirect()->back()->withErrors(['recipient_id' => 'No recipients found for selected group.'])->withInput();
            }

            foreach ($recipients as $recipientId) {
                Message::create([
                    'sender_id' => $senderId,
                    'recipient_id' => $recipientId,
                    'subject' => $data['subject'],
                    'content' => $content,
                ]);
            }

            return redirect()->route('communication.messages.index')->with('success', 'Message sent successfully.');
        }

        if (! ctype_digit($recipientKey)) {
            return redirect()->back()->withErrors(['recipient_id' => 'Invalid recipient selected.'])->withInput();
        }

        $recipientId = (int) $recipientKey;
        if ($recipientId === $senderId || ! User::whereKey($recipientId)->exists()) {
            return redirect()->back()->withErrors(['recipient_id' => 'Invalid recipient selected.'])->withInput();
        }

        Message::create([
            'sender_id' => $senderId,
            'recipient_id' => $recipientId,
            'subject' => $data['subject'],
            'content' => $content,
        ]);

        return redirect()->route('communication.messages.index')->with('success', 'Message sent successfully.');
    }

    private function getGroupRecipients(string $groupKey, int $senderId)
    {
        $query = User::query()
            ->where('id', '!=', $senderId)
            ->whereNull('deleted_at');

        if ($groupKey === 'group:teachers') {
            $query->role('Teacher');
        } elseif ($groupKey === 'group:students') {
            $query->role('Student');
        } elseif ($groupKey === 'group:staff') {
            $query->whereHas('roles', function ($q) {
                $q->whereNotIn('name', ['Student', 'Parent']);
            });
        }

        return $query->pluck('id');
    }

    private function sanitizeMessageHtml(string $html): string
    {
        $html = trim($html);
        if ($html === '') {
            return '';
        }

        $allowedTags = [
            'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's',
            'ul', 'ol', 'li',
            'a',
            'h1', 'h2', 'h3',
            'blockquote',
        ];

        $allowedAttributes = [
            'a' => ['href'],
        ];

        libxml_use_internal_errors(true);
        $doc = new \DOMDocument;
        $doc->loadHTML('<?xml encoding="utf-8" ?>'.$html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $xpath = new \DOMXPath($doc);
        foreach ($xpath->query('//*') as $node) {
            $tag = strtolower($node->nodeName);
            if (! in_array($tag, $allowedTags, true)) {
                while ($node->firstChild) {
                    $node->parentNode->insertBefore($node->firstChild, $node);
                }
                $node->parentNode->removeChild($node);

                continue;
            }

            $allowedForTag = $allowedAttributes[$tag] ?? [];
            if ($node->hasAttributes()) {
                $toRemove = [];
                foreach ($node->attributes as $attr) {
                    $name = strtolower($attr->nodeName);
                    if (! in_array($name, $allowedForTag, true)) {
                        $toRemove[] = $name;
                    }
                }
                foreach ($toRemove as $name) {
                    $node->removeAttribute($name);
                }
            }

            if ($tag === 'a' && $node->hasAttribute('href')) {
                $href = trim((string) $node->getAttribute('href'));
                $lower = strtolower($href);
                $isUnsafe = $href === '' || str_starts_with($lower, 'javascript:') || str_starts_with($lower, 'data:');

                if (! $isUnsafe) {
                    $scheme = parse_url($href, PHP_URL_SCHEME);
                    if ($scheme !== null) {
                        $scheme = strtolower((string) $scheme);
                        if (! in_array($scheme, ['http', 'https', 'mailto', 'tel'], true)) {
                            $isUnsafe = true;
                        }
                    }
                }

                if ($isUnsafe) {
                    $node->removeAttribute('href');
                }
            }
        }

        $clean = trim((string) $doc->saveHTML());

        return $clean;
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
