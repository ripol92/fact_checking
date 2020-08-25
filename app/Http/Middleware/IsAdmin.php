<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /**@var User $user */
        $user = $request->user();
        if (is_null($user)) {
            return response()->json(["msg" => "not found"], 404);
        }

        if (!$user->is_admin) {
            return response()->json(["msg" => "not allowed"], 401);
        }

        return $next($request);
    }
}
