<?php

use App\Http\Controllers\user\HomeController;
use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index');
});
