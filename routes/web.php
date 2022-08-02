<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('client')->group(function () {
    Route::view('/login', 'login.client')->name('client.login');
});

Route::prefix('manager')->group(function () {
    Route::view('/login', 'login.staff')->name('manager.login');
});

Route::middleware(['auth:manager'])->prefix('manager')->group(function () {
    Route::view('/dashboard', 'manager.dashboard');
});
