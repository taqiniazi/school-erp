<?php

namespace App\Http\Middleware;

use App\Services\SchoolContext;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\PermissionRegistrar;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('Super Admin')) {
                SchoolContext::setSchoolId(null);
                app(PermissionRegistrar::class)->setPermissionsTeamId(null);

                return $next($request);
            }
            if ($user->school_id) {
                SchoolContext::setSchoolId($user->school_id);
                app(PermissionRegistrar::class)->setPermissionsTeamId($user->school_id);
            }
        }

        return $next($request);
    }
}
