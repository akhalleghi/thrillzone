<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * نمایش صفحه اصلی
     */
    public function index()
    {
        return view('index');
    }

    /**
     * نمایش صفحه درباره ما
     */
    public function about()
    {
        return view('about');
    }

    /**
     * نمایش صفحه سؤالات متداول
     */
    public function faq()
    {
        return view('faq');
    }

    /**
     * نمایش صفحه ورود
     */
    public function login()
    {
        return view('login');
    }

    /**
     * نمایش صفحه ویدیو
     */
    public function video()
    {
        return view('video');
    }

    /**
     * نمایش صفحه پکیج‌ها
     */
    public function packages()
    {
        return view('index2');
    }

    public function admindashboard()
    {
        return view('admin-dashboard');
    }
}
