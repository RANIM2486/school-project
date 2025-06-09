<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StudentController;
 use App\Http\Controllers\SubjectController;
use App\Http\Controllers\PointController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ITController;
use App\Http\Controllers\CurrentStudentController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// 🔐 Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


// 🧑‍🏫 Teacher Routes
Route::middleware(['auth:sanctum', 'role:teacher'])->prefix('teacher')->group(function () {
    Route::get('/classes', [TeacherController::class, 'myClasses']);
    Route::get('/sections', [TeacherController::class, 'mySections']);
    Route::get('/sections/{sectionId}/students', [TeacherController::class, 'studentsInSection']);
    Route::get('/subjects', [TeacherController::class, 'mySubjects']);
    Route::post('/points', [TeacherController::class, 'givePoint']);
    Route::post('/grades', [TeacherController::class, 'addGrade']);
    Route::post('/notes', [TeacherController::class, 'addNote']);
});

// 🧭 Guide Routes
Route::middleware(['auth:sanctum', 'role:guide'])->prefix('guide')->group(function () {
    Route::get('/my-sections', [GuideController::class, 'mySections']);
    Route::get('/sections/{sectionId}/students', [GuideController::class, 'studentsInSection']);
    Route::post('/grades', [GuideController::class, 'addGrade']);
    Route::post('/ads', [GuideController::class, 'postAd']);
    Route::post('/points', [GuideController::class, 'givePoint']);
    Route::post('/attendance', [GuideController::class, 'markAttendance']);
});

// 🧑‍💻 IT Routes
Route::middleware(['auth:sanctum', 'role:it'])->prefix('it')->group(function () {
    Route::post('/create-user', [ITController::class, 'createUser']);

    Route::post('/sections', [ITController::class, 'createSection']);
    Route::put('/sections/{id}', [ITController::class, 'updateSection']);
    Route::delete('/sections/{id}', [ITController::class, 'deleteSection']);

    Route::post('/subjects', [ITController::class, 'createSubject']);
    Route::put('/subjects/{id}', [ITController::class, 'updateSubject']);
    Route::delete('/subjects/{id}', [ITController::class, 'deleteSubject']);

    Route::post('/classes', [ITController::class, 'createClass']);
    Route::put('/classes/{id}', [ITController::class, 'updateClass']);
    Route::delete('/classes/{id}', [ITController::class, 'deleteClass']);
});


// 👑 Admin Routes
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/classes', [AdminController::class, 'allClasses']);
    Route::get('/sections', [AdminController::class, 'allSections']);
    Route::get('/students', [AdminController::class, 'allStudents']);
    Route::get('/teachers', [AdminController::class, 'allTeachers']);
    Route::get('/points', [AdminController::class, 'allPoints']);
    Route::get('/subjects', [AdminController::class, 'allSubjects']);
    Route::get('/grades', [AdminController::class, 'allGrades']);
    Route::get('/ads', [AdminController::class, 'allAds']);
});

// 👤 Public (Authenticated) Routes
Route::middleware('auth:sanctum')->group(function () {
    // Classes - مشاهدة فقط (لـ admin مثلاً)
    Route::get('/classes', [ClassesController::class, 'index']);
    Route::get('/classes/{id}', [ClassesController::class, 'show']);

    // Students
    Route::get('/students', [StudentController::class, 'index']);
    Route::post('/students', [StudentController::class, 'store']);
    Route::get('/students/{id}', [StudentController::class, 'show']);
    Route::put('/students/{id}', [StudentController::class, 'update']);
    Route::delete('/students/{id}', [StudentController::class, 'destroy']);
    //current _Students
    Route::apiResource('current-students', CurrentStudentController::class);
    Route::get('/count/active', [CurrentStudentController::class, 'countActive']);
    Route::get('/count/postponed', [CurrentStudentController::class, 'countPostponed']);
    Route::get('/count/left', [CurrentStudentController::class, 'countLeft']);
    Route::get('/count/class/{classId}', [CurrentStudentController::class, 'countByClass']);
    Route::get('/count/section/{sectionId}', [CurrentStudentController::class, 'countBySection']);

    // Comments
    Route::middleware(['auth:sanctum', 'role:teacher,guide'])->group(function () {
    Route::get('/comments', [CommentController::class, 'index']);
    Route::post('/comments', [CommentController::class, 'store']);
    Route::get('/comments/{id}', [CommentController::class, 'show']);
    Route::put('/comments/{id}', [CommentController::class, 'update']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);});

    // Grades (عرض فقط)
    Route::get('/grades', [GradeController::class, 'index']);
    Route::get('/grades/{id}', [GradeController::class, 'show']);
    Route::put('/grades/{id}', [GradeController::class, 'update']);
    Route::delete('/grades/{id}', [GradeController::class, 'destroy']);

    // Points (عرض فقط)
    Route::get('/points', [PointController::class, 'index']);
    Route::get('/points/{id}', [PointController::class, 'show']);
    Route::get('/students/{studentId}/points', [PointController::class, 'getStudentPoints']);
    Route::get('/students/{studentId}/total', [PointController::class, 'getStudentTotalPoints']);
    Route::get('/students/{studentId}/points/{type}', [PointController::class, 'getPointsByType']);


});
