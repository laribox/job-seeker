<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isPremiumUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()->billing_end >= now() || $request->user()->trial  >= now()) {
            return $next($request);
        } else {
            return redirect()->route('dashboard')->with('error', 'this is not a premium user');
        }
    }
}
