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
Route::prefix('manager')->group(function () {
    Route::post('login', [ManagerController::class, 'authenticate']);
});

Route::prefix('client')->group(function () {
    Route::post('login', [ManagerController::class, 'authenticate']);
});

Route::middleware(['auth:manager'])->prefix('manager')->group(function () {
    Route::prefix('company')->group(function () {
        Route::get('list', [CompanyController::class, 'index']);
        Route::post('store', [CompanyController::class, 'store']);
        Route::patch('{id}/update', [CompanyController::class, 'update']);
        Route::delete('{id}/delete', [CompanyController::class, 'destroy']);
    });
});
