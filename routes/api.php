<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function(){
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::get('/logout', [AuthenticationController::class, 'logout']);
        Route::get('/user', [AuthenticationController::class, 'index']);
        Route::post('/post', [PostController::class, 'store']);
        Route::put('/post/{id}', [PostController::class, 'edit'])->middleware('postowner');
        Route::delete('/post-new/{id}', [PostController::class, 'destroy'])->middleware('postowner');
    });

    Route::get('/post', [PostController::class, 'index']);
    Route::get('/post/{id}', [PostController::class, 'show']);

    Route::post('/login', [AuthenticationController::class, 'login']);

    Route::post('/user-add', [UserController::class, 'store']);
});



