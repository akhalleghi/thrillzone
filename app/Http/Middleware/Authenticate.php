<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * تعیین مسیر ریدایرکت وقتی کاربر احراز هویت نشده است.
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if (
                $request->routeIs('admin.*')
                || $request->is('admin')
                || $request->is('admin/*')
            ) {
                return route('admin.login');
            }

            return route('auth.login');
        }
    }
}
