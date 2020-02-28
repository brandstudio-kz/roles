<?php

namespace BrandStudio\Roles\Http\Middleware;

use Closure;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, string $role)
    {
        $user = $request->user;
        if (config('roles.use_backpack') && backpack_user()) {
            $user = backpack_user();
        }

        if (!$user) {
            abort(401, trans('brandstudio::roles.unauthorized'));
        }

        if (!$user->hasAnyRole(explode('|', $role))) {
            abort(403, trans('brandstudio::roles.permission_denied'));
        }

        return $next($request);
    }
}
