<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PointController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// point route
Route::middleware(['auth:sanctum', 'role:teacher'])->group(function () {
    Route::post('/points', [PointController::class, 'store']);
    Route::put('/points/{id}', [PointController::class, 'update']);
    Route::delete('/points/{id}', [PointController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/points', [PointController::class, 'index']);
    Route::get('/points/{id}', [PointController::class, 'show']);
    Route::get('/students/{studentId}/points', [PointController::class, 'getStudentPoints']);
    Route::get('/students/{studentId}/total', [PointController::class, 'getStudentTotalPoints']);
    Route::get('/students/{studentId}/points/{type}', [PointController::class, 'getPointsByType']);
});


