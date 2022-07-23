<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;

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

Route::post('/login',[AuthController::class, 'Login']);
Route::post('/inscription',[AuthController::class,'Inscription']);

Route::group(['middleware'=>['auth:sanctum']], function () {
    Route::get('/users',[UserController::class, 'index']);
    Route::put('/user/{id}',[UserController::class, 'update']);
    Route::put('/valider/user/{id}',[UserController::class, 'ValidationCompte']);
    Route::post('/user',[UserController::class, 'store']);
    Route::delete('/user/{id}',[UserController::class, 'destroy']);

    Route::post('/logout',[AuthController::class, 'Logout']);
});
