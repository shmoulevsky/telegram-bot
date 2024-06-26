<?php


use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1', 'middleware' => 'api'], function (){

    Route::post('/login', [AuthController::class, 'login'])->name('login');


    Route::middleware('auth:jwt')
        ->group(function () {
            Route::post('/login/refresh', [AuthController::class, 'refreshCode'])->name('user.login.refresh');
            Route::post('/login/check', [AuthController::class, 'checkLoginCode'])->name('user.login.check');
        });

    // Эндпоинты с подтвержденной авторизацией
    Route::group(['middleware' => ['auth:sanctum', 'two-factor']], function (){
        Route::get('/user', [UserController::class, 'show'])->name('user');
    });

});
