<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Models\classes;
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

<<<<<<< HEAD
// المدير: فقط عرض الصفوف
Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::get('/classes', [ClassesController::class, 'index']);
    Route::get('/classes/{id}', [ClassesController::class, 'show']);
=======
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
>>>>>>> e354ead742d1df6091ba8ed24dbc7735d5ce5a00
});

// مسؤول IT: إضافة، تعديل، حذف
Route::middleware(['auth:sanctum', 'role:it'])->group(function () {
    Route::post('/classes', [ClassesController::class, 'store']);
    Route::put('/classes/{id}', [ClassesController::class, 'update']);
    Route::delete('/classes/{id}', [ClassesController::class, 'destroy']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/comments', [CommentController::class, 'index']);
    Route::post('/comments', [CommentController::class, 'store']);
    Route::get('/comments/{id}', [CommentController::class, 'show']);
    Route::put('/comments/{id}', [CommentController::class, 'update']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/grades', [GradeController::class, 'index']);
    Route::post('/grades', [GradeController::class, 'store']);
    Route::get('/grades/{id}', [GradeController::class, 'show']);
    Route::put('/grades/{id}', [GradeController::class, 'update']);
    Route::delete('/grades/{id}', [GradeController::class, 'destroy']);
});
Route::middleware(['auth:sanctum'])->group(function () {

    // 🔹 المدير: استعراض فقط
    Route::middleware('role:admin')->group(function () {
        Route::get('/sections', [SectionController::class, 'index']);
        Route::get('/sections/{id}', [SectionController::class, 'show']);
    });

    // 🔹 مسؤول IT: تعديل فقط
    Route::middleware('role:it')->group(function () {
        Route::post('/sections', [SectionController::class, 'store']);
        Route::put('/sections/{id}', [SectionController::class, 'update']);
        Route::delete('/sections/{id}', [SectionController::class, 'destroy']);
    });

});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/students', [StudentController::class, 'index']);
    Route::post('/students', [StudentController::class, 'store']);
    Route::get('/students/{id}', [StudentController::class, 'show']);
    Route::put('/students/{id}', [StudentController::class, 'update']);
    Route::delete('/students/{id}', [StudentController::class, 'destroy']);
});
Route::middleware(['auth:sanctum'])->group(function () {

    // للمدير فقط: عرض المواد
    Route::middleware('role:admin')->group(function () {
        Route::get('/subjects', [SubjectController::class, 'index']);
        Route::get('/subjects/{id}', [SubjectController::class, 'show']);
    });

    // لمسؤول IT فقط: إضافة، تعديل، حذف
    Route::middleware('role:it')->group(function () {
        Route::post('/subjects', [SubjectController::class, 'store']);
        Route::put('/subjects/{id}', [SubjectController::class, 'update']);
        Route::delete('/subjects/{id}', [SubjectController::class, 'destroy']);
    });

});
