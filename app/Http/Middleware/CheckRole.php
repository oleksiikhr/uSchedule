<?php

namespace App\Http\Middleware;

use Closure;
use Zizaco\Entrust\Middleware\EntrustRole;

class CheckRole extends EntrustRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure $next
     * @param  $roles
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        if (!is_array($roles)) {
            $roles = explode(self::DELIMITER, $roles);
        }

        if ($this->auth->guest() || !$request->user()->hasRole($roles)) {
            abort(403, 'You don\'t have permissions to this action');
        }

        return $next($request);
    }
}
