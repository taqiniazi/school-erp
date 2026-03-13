<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromUser
{
    public function handle(Request $request, Closure $next): Response
    {
        $locale = null;

        if ($request->hasSession()) {
            $locale = $request->session()->get('locale');
        }

        if (! $locale && $request->user() && is_array($request->user()->ui_settings)) {
            $locale = $request->user()->ui_settings['locale'] ?? null;
        }

        if (! $locale) {
            $locale = config('app.locale');
        }

        if (in_array($locale, ['en', 'es'], true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
