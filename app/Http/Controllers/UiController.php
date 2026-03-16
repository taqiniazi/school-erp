<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UiController extends Controller
{
    public function settings(Request $request)
    {
        $user = Auth::user();

        return response()->json([
            'theme' => data_get($user->ui_settings, 'theme'),
            'locale' => data_get($user->ui_settings, 'locale'),
            'dashboard' => data_get($user->ui_settings, 'dashboard', []),
        ]);
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'theme' => ['sometimes', 'nullable', 'in:light,dark'],
            'locale' => ['sometimes', 'nullable', 'in:en,es'],
            'dashboard' => ['sometimes', 'array'],
            'dashboard.*' => ['nullable'],
        ]);

        $user = $request->user();
        $settings = is_array($user->ui_settings) ? $user->ui_settings : [];

        if (array_key_exists('theme', $validated)) {
            if ($validated['theme'] === null) {
                unset($settings['theme']);
            } else {
                $settings['theme'] = $validated['theme'];
            }
        }

        if (array_key_exists('locale', $validated)) {
            if ($validated['locale'] === null) {
                unset($settings['locale']);
            } else {
                $settings['locale'] = $validated['locale'];
            }
        }

        if (array_key_exists('dashboard', $validated)) {
            $existingDashboard = isset($settings['dashboard']) && is_array($settings['dashboard']) ? $settings['dashboard'] : [];
            $incomingDashboard = $validated['dashboard'] ?? [];
            if (! is_array($incomingDashboard)) {
                $incomingDashboard = [];
            }
            $settings['dashboard'] = array_replace_recursive($existingDashboard, $incomingDashboard);
        }

        $user->ui_settings = $settings;
        $user->save();

        if (! empty($settings['locale'])) {
            $request->session()->put('locale', $settings['locale']);
        }

        return response()->json(['ok' => true]);
    }

    public function setLocale(Request $request)
    {
        $validated = $request->validate([
            'locale' => ['required', 'in:en,es'],
        ]);

        $user = $request->user();
        $settings = is_array($user->ui_settings) ? $user->ui_settings : [];
        $settings['locale'] = $validated['locale'];
        $user->ui_settings = $settings;
        $user->save();

        $request->session()->put('locale', $validated['locale']);

        return back();
    }

    public function notifications(Request $request)
    {
        $limit = (int) $request->query('limit', 5);
        $limit = max(1, min(20, $limit));

        $user = $request->user();
        $unreadCount = $user->unreadNotifications()->count();
        $latest = $user->unreadNotifications()->latest()->limit($limit)->get();

        return response()->json([
            'unread_count' => $unreadCount,
            'items' => $latest->map(function ($n) {
                $data = is_array($n->data) ? $n->data : [];

                return [
                    'id' => $n->id,
                    'type' => $n->type,
                    'title' => $data['title'] ?? __('Notification'),
                    'url' => $data['url'] ?? null,
                    'created_at' => optional($n->created_at)->toIso8601String(),
                    'created_human' => optional($n->created_at)->diffForHumans(),
                ];
            })->values(),
        ]);
    }

    public function markAllNotificationsRead(Request $request)
    {
        $request->user()->unreadNotifications()->update(['read_at' => now()]);

        if ($request->wantsJson()) {
            return response()->json(['ok' => true]);
        }

        return back();
    }
}
