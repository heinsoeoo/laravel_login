<?php

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

Route::group([
    'middleware' => 'api',
], function() {
    Route::post('/login', [\App\Http\Controllers\UserController::class, 'login'])->name('login');
    Route::post('/logout', [\App\Http\Controllers\UserController::class, 'logout']);
    Route::post('/users', [\App\Http\Controllers\UserController::class, 'userList']);
});
