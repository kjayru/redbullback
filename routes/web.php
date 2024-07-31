<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    print_r("proceso de registros");
});

Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
    'login'=>true
 ]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
