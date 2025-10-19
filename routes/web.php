<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/packages', function () {
    return view('index2');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/faq', function () {
    return view('faq');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/tutorial', function () {
    return view('video');
});
