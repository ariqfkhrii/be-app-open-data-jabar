<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataTableController;
use App\Http\Controllers\UserController;

Route::prefix('datatable')->group(function () {
    Route::post('/store', [DataTableController::class, 'store']);
    Route::put('/update/{id}', [DataTableController::class, 'update']);
    Route::delete('/destroy/{id}', [DataTableController::class, 'destroy']);
    Route::get('/index/full', [DataTableController::class, 'index']);
    Route::get('/index/{id}', [DataTableController::class, 'show']);
});

    Route::prefix('user')->group(function () {
        Route::post('/register', [UserController::class, 'register']);
        Route::post('/login', [UserController::class, 'login']);
        Route::put('/update/{id}', [UserController::class, 'update']);
        Route::delete('/destroy/{id}', [UserController::class, 'destroy']);
        Route::get('/show/{id}', [UserController::class, 'show']);
});
