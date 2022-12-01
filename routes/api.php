<?php

use App\Http\Controllers\RemoteGeneration\ApplicationController;
use App\Http\Controllers\RemoteGeneration\ApplicationFilesController;
use App\Http\Controllers\RemoteGeneration\ApplicationTemplateFilesController;
use App\Http\Controllers\RemoteGeneration\ClientGroupController;
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
        Route::patch('templates/{template_id}/update', [TemplatesController::class, 'update']);
        Route::delete('templates/{template_id}/delete', [TemplatesController::class, 'destroy']);

        Route::get('templates/{template_id}/files', [ApplicationTemplateFilesController::class, 'index']);
        Route::post('templates/{template_id}/files/store', [ApplicationTemplateFilesController::class, 'store']);
        Route::get('templates/files/{file_id}/show', [ApplicationTemplateFilesController::class, 'show']);
        Route::delete('templates/files/{file_id}/delete', [ApplicationTemplateFilesController::class, 'destroy']);
    });

    Route::prefix('application')->group(function () {
        Route::get('index', [ApplicationController::class, 'index']);
        Route::post('registrate', [ApplicationController::class, 'registrateApplication']);
        Route::delete('{id}/delete', [ApplicationController::class, 'destroy']);

        Route::prefix('{application}/files')->group(function () {
            Route::get('index', [ApplicationFilesController::class, 'index']);
            Route::get('{rgApplicationFiles}/show', [ApplicationFilesController::class, 'show']);
            Route::post('store', [ApplicationFilesController::class, 'store']);
            Route::delete('{rgApplicationFiles}/delete', [ApplicationFilesController::class, 'destroy']);
        });
    });

    Route::prefix('client')->group(function () {
        Route::get('index', [\App\Http\Controllers\RemoteGeneration\ClientController::class, 'index']);
        Route::post('store', [\App\Http\Controllers\RemoteGeneration\ClientController::class, 'store']);
        Route::patch('{rgClient}/update', [\App\Http\Controllers\RemoteGeneration\ClientController::class, 'update']);
        Route::get('{rgClient}/show', [\App\Http\Controllers\RemoteGeneration\ClientController::class, 'show']);
        Route::delete('{rgClient}/delete', [\App\Http\Controllers\RemoteGeneration\ClientController::class, 'destroy'])->withTrashed();
    });

    Route::prefix('group')->group(function () {
        Route::get('list', [ClientGroupController::class, 'index']);
        Route::get('{rgClient}/show', [ClientGroupController::class, 'show']);
        Route::patch('{rgClient}/update', [ClientGroupController::class, 'update']);
    });
});

Route::middleware(['auth:rg-client'])->prefix('rg-client')->group(function () {
    Route::prefix('company')->group(function () {
        Route::get('list', [CompanyController::class, 'indexCompanyByClientGroup']);
        Route::get('/{company}/application/list', [ApplicationController::class, 'indexApplicationsByCompany']);
    });

});
