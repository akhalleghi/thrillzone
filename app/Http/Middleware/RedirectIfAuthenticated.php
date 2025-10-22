<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * اگر کاربر لاگین کرده باشد، او را از صفحه ورود دور کن
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            // هدایت به داشبورد در صورت ورود کاربر
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
