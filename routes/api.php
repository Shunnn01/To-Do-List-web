<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskApiController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;


Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);


Route::middleware(['auth:sanctum', 'check.token.expiry'])->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::post('/tasks', [TaskApiController::class, 'store']);
    Route::put('/tasks/{id}', [TaskApiController::class, 'update']);
    Route::delete('/tasks/{id}', [TaskApiController::class, 'destroy']);
    Route::get('/tasks/{id?}', [TaskApiController::class, 'index']);
});
