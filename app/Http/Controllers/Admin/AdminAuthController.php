<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        // اگر قبلاً لاگین است، به داشبورد بفرست
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => ['required','string','max:100'],
            'password' => ['required','string','min:6'],
            'remember' => ['nullable','boolean'],
        ],[
            'username.required' => 'نام کاربری را وارد کنید',
            'password.required' => 'رمز عبور را وارد کنید',
        ]);

        $credentials = $request->only('username','password');
        $remember    = (bool)$request->boolean('remember');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate(); // جلوگیری از Session Fixation
            return redirect()->intended(route('admin.dashboard'))
                ->with('success','ورود موفقیت‌آمیز بود');
        }

        return back()->withErrors(['username' => 'نام کاربری یا رمز عبور اشتباه است'])
            ->withInput($request->only('username'));
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 🔹 مسیر صحیح برای لاگین ادمین:
        return redirect()->route('admin.login')
            ->with('success', 'شما با موفقیت از پنل مدیریت خارج شدید.');
    }

}
