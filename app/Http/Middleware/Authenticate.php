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
        // اگر کاربر وارد نشده
        if (!Auth::check()) {
            return redirect()->route('auth.login');
        }

        // در غیر این صورت ادامه درخواست
        return $next($request);
    }
}
