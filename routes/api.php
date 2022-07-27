<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\Login\ClientController;
use App\Http\Controllers\Login\ManagerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [ManagerController::class, 'authenticate'])->prefix('manager');
Route::post('login', [ClientController::class, 'authenticate'])->prefix('client');

Route::middleware(['auth:manager'])->prefix('manager')->group(function () {
    Route::prefix('company')->group(function () {
        Route::post('store', [CompanyController::class, 'store']);
    });
});
