<?php

use App\Http\Controllers\RemoteGeneration\CompanyController;
use App\Http\Controllers\RemoteGeneration\Login\ClientController;
use App\Http\Controllers\RemoteGeneration\Login\ManagerController;
use App\Http\Controllers\RemoteGeneration\TemplatesController;
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
Route::prefix('rg-manager')->group(function () {
    Route::post('login', [ManagerController::class, 'authenticate']);
});

Route::prefix('rg-client')->group(function () {
    Route::post('login', [ClientController::class, 'authenticate']);
});

Route::middleware(['auth:rg-manager'])->prefix('rg-manager')->group(function () {
    Route::prefix('company')->group(function () {
        Route::get('list', [CompanyController::class, 'index']);
        Route::post('store', [CompanyController::class, 'store']);
        Route::patch('{id}/update', [CompanyController::class, 'update']);
        Route::delete('{id}/delete', [CompanyController::class, 'destroy']);
        Route::get('{id}/templates', [TemplatesController::class, 'index']);
        Route::post('{id}/templates/store', [TemplatesController::class, 'store']);
        Route::get('templates/{template_id}/show', [TemplatesController::class, 'show']);
        Route::post('templates/{template_id}/update', [TemplatesController::class, 'update']);
        Route::post('templates/{template_id}/delete', [TemplatesController::class, 'destroy']);
    });
});
