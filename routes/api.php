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
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/points', [PointController::class, 'index']);         // عرض كل النقاط
    Route::post('/points', [PointController::class, 'store']);        // إنشاء نقطة جديدة
    Route::get('/points/{id}', [PointController::class, 'show']);     // عرض نقطة معينة
    Route::put('/points/{id}', [PointController::class, 'update']);   // تحديث نقطة
    Route::delete('/points/{id}', [PointController::class, 'destroy']); // حذف نقطة
});



