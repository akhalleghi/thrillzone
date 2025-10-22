<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// مسیرهای اصلی سایت با استفاده از PageController
Route::get('/', [PageController::class, 'index']);
Route::get('/about', [PageController::class, 'about']);
Route::get('/faq', [PageController::class, 'faq']);
Route::get('/login', [PageController::class, 'login']);
Route::get('/video', [PageController::class, 'video']);
Route::get('/packages', [PageController::class, 'packages']);
Route::get('/admindashboard', [PageController::class, 'admindashboard']);


Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/tutorial', function () {
    return view('video');
});
