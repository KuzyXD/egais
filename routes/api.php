<?php

use App\Http\Controllers\Login\ClientController;
use App\Http\Controllers\Login\ManagerController;
use Illuminate\Http\Request;
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
