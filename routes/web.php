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
Route::prefix('rg-client')->group(function () {
    Route::view('/login', 'login.client')->name('client.login');
    Route::view('/action', 'client.action')->name('client.action')->middleware('signed');
});

Route::middleware(['auth:rg-client'])->prefix('rg-client')->group(function () {
    Route::view('/dashboard', 'client.dashboard');
    Route::view('/list/applications', 'client.application_list')->name('client.application_list');
});


Route::prefix('rg-manager')->group(function () {
    Route::view('/login', 'login.staff')->name('manager.login');
});

Route::middleware(['auth:rg-manager'])->prefix('rg-manager')->group(function () {
    Route::view('/dashboard', 'manager.dashboard');

    Route::prefix('list')->group(function () {
        Route::view('/clients', 'manager.clients_list')->name('manager.clients_list');
        Route::view('/companies', 'manager.company_list')->name('manager.companies');
        Route::view('/companies/{id}/templates', 'manager.templates')->name('manager.companies.templates');
        Route::view('/applications', 'manager.application_list')->name('manager.applications');
    });
});
