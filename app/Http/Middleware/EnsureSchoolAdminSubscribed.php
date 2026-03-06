<?php

namespace App\Http\Middleware;

use App\Models\Subscription;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSchoolAdminSubscribed
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user) {
            return $next($request);
        }

        if ($request->routeIs('billing.*')) {
            return $next($request);
        }

        if ($user->hasRole('Super Admin')) {
            return $next($request);
        }

        if (! $user->hasRole('School Admin')) {
            return $next($request);
        }

        $school = $user->school;
        if (! $school || ! $school->is_active) {
            abort(403);
        }

        $now = now();
        $hasActiveSubscription = Subscription::query()
            ->where('school_id', $school->id)
            ->whereIn('status', ['active', 'trialing'])
            ->where(function ($q) use ($now) {
                $q->whereNull('current_period_end')->orWhere('current_period_end', '>=', $now);
            })
            ->exists();

        if (! $hasActiveSubscription) {
            return redirect()->route('billing.choose-plan');
        }

        return $next($request);
    }
}
