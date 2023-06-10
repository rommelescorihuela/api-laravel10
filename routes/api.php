<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Regions;
use App\Http\Controllers\Communes;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('auth/registro',[AuthController::class, 'create']);
Route::post('auth/login',[AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::resource('customers',CustomersController::class);
    Route::delete('/customersdelete',[CustomersController::class, 'destroy']);
    Route::get('/customersone',[CustomersController::class, 'one']);
    Route::post('auth/logout',[AuthController::class, 'logout']);
});