<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    /**
     * بررسی لاگین بودن کاربر
     */
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            // 👇 اینجا نام صحیح روت لاگین در پروژه‌ات است
            return redirect()->route('auth.login');
        }

        return $next($request);
    }
}
