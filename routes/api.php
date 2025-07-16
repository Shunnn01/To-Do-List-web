<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskApiController;

Route::post('/tasks', [TaskApiController::class, 'store']);   
Route::put('/tasks/{id}', [TaskApiController::class, 'update']);
Route::delete('/tasks/{id}', [TaskApiController::class, 'destroy']);
Route::get('/tasks/{id?}', [TaskApiController::class, 'index']);
