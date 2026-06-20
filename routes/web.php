<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


//------------------ Home Module --------------------------------
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/login', 'login')->name('login');
    // Route::get('/sidebar', 'sidebar')->name('sidebar');
    Route::get('/dashboard', 'dashboard')->name('dashboard');
});

// Route::controller()