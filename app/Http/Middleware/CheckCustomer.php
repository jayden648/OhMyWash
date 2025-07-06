<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCustomer
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isCustomer()) {
            return redirect()->route('home')->with('error', 'Akses ditolak!');
        }

        return $next($request);
    }
}