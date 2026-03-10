<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckoutMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            // Redirect guests to login, saving intended checkout URL
            session()->put('url.intended', url()->current());
            return redirect()->route('login')->with('warning', 'Please login to continue with checkout.');
        }

        return $next($request);
    }
}
