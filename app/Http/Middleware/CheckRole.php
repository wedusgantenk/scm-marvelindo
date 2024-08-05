<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $roles = array_slice(func_get_args(), 2);

        foreach ($roles as $role) {
            if (empty(auth()->user()->hak_akses)) {
                return abort(404);
            } else {
                $user = auth()->user()->hak_akses;
                if ($user == $role) {
                    return $next($request);
                }
            }
        }

        // return redirect('/');
        return abort(404);
    }
}
