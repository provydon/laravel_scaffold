<?php

namespace App\Http\Middleware;

use App\Services\AllServices\General;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogUserForTheDay
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user) {
            try {
                General::logUserForTheDay($user);
            } catch (\Throwable $th) {
                return route('login');
            }
        }

        return $next($request);
    }
}
