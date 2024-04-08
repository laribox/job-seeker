<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class isAlreadySubscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->user()->billing_end >= now() && $request->user()->status == 'paid') {
            return redirect()->route('dashboard')->with('error', 'Your subscription is still active');
        }
        return $next($request);
    }
}
