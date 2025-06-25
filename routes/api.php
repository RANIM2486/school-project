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
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdController;
use App\Http\Controllers\ParentController;
use App\Http\Controllers\FeeController;

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
    //  إدارة الشعب
    Route::get('/sections', [GuideController::class, 'mySections']); // استعراض الشعب التي يشرف عليها المرشد

     Route::get('/sections/{sectionId}/students', [GuideController::class, 'studentsInSection']); // طلاب شعبة محددة
    //  إدارة العلامات
     Route::prefix('grades')->group(function () {
        // إضافة أو تعديل تلقائي (إنشاء إذا لا يوجد)
         Route::post('/', [GuideController::class, 'addGrade']);
        // استعراض كل العلامات لطلاب المرشد
         Route::get('/', [GuideController::class, 'getGrades']);
        // استعراض علامات طالب معين
         Route::get('/student/{student_id}', [GuideController::class, 'showStudentGrades']);
        // تعديل سجل علامة موجود
          Route::put('/{id}', [GuideController::class, 'updateGrade']);
        // حذف علامة
        Route::delete('/{id}', [GuideController::class, 'deleteGrade']);

    });

    // الإعلانات
    Route::get('/ads', [AdController::class, 'index']);        // عرض كل الإعلانات
    Route::get('/ads/{id}', [AdController::class, 'show']);    // عرض إعلان واحد
    Route::post('/ads', [AdController::class, 'store']);       // إنشاء إعلان
    Route::put('/ads/{id}', [AdController::class, 'update']);  // تعديل إعلان
    Route::delete('/ads/{id}', [AdController::class, 'destroy']); // حذف إعلان
    //  تسجيل حضور
    Route::post('/attendance', [GuideController::class, 'addAttendance']);
});

// 🧑‍💻 IT Routes

<
 Route::middleware(['auth:sanctum','role:it'])->group(function () {

    Route::post('/users', [ITController::class, 'createUser']);


    Route::post('/classes', [ITController::class, 'createClass']);
     Route::patch('/classes/{id}', [ITController::class, 'updateClass']);
    Route::delete('/classes/{id}', [ITController::class, 'deleteClass']);

     Route::post('/sections', [ITController::class, 'createSection']);
    Route::patch('/sections/{id}', [ITController::class, 'updateSection']);
     Route::delete('/sections/{id}', [ITController::class, 'deleteSection']);

 Route::post('/subjects', [ITController::class, 'createSubject']);
    Route::patch('/subjects/{id}', [ITController::class, 'updateSubject']);
    Route::delete('/subjects/{id}', [ITController::class, 'deleteSubject']);

    Route::post('/students', [ITController::class, 'createStudent']);
    Route::patch('/students/{id}', [ITController::class, 'updateStudent']);
    Route::delete('/students/{id}', [ITController::class, 'deleteStudent']);

   Route::post('/buses', [ITController::class, 'createBus']);
    Route::patch('/buses/{id}', [ITController::class, 'updateBus']);

     Route::delete('/buses/{id}', [ITController::class, 'deleteBus']);
    Route::delete('/buses/{id}', [ITController::class, 'deleteBus']);
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
     //current _Students
    Route::apiResource('current-students', CurrentStudentController::class);
    Route::get('/count/active', [CurrentStudentController::class, 'countActive']);
    Route::get('/count/postponed', [CurrentStudentController::class, 'countPostponed']);
    Route::get('/count/left', [CurrentStudentController::class, 'countLeft']);
    Route::get('/count/class/{classId}', [CurrentStudentController::class, 'countByClass']);
    Route::get('/count/section/{sectionId}', [CurrentStudentController::class, 'countBySection']);

    // Comments
    Route::middleware(['auth:sanctum', 'role:teacher|guide'])->group(function () {
    Route::get('/comments', [CommentController::class, 'index']);
    Route::post('/comments', [CommentController::class, 'store']);
    Route::get('/comments/{id}', [CommentController::class, 'show']);
    Route::put('/comments/{id}', [CommentController::class, 'update']);
    Route::delete('/comments/{id}', [CommentController::class, 'destroy']);});
    


    // Points (عرض فقط)
    Route::middleware(['auth:sanctum', 'role:teacher,guide'])->group(function () {
    Route::get('/points', [PointController::class, 'index']);
    Route::post('/points', [PointController::class, 'store']);
    Route::get('/points/{id}', [PointController::class, 'show']);
    Route::put('/points/{id}', [PointController::class, 'update']);
    Route::delete('/points/{id}', [PointController::class, 'destroy']);
    Route::get('/students/{studentId}/points', [PointController::class, 'getStudentPoints']);
    Route::get('/students/{studentId}/total-points', [PointController::class, 'getStudentTotalPoints']);
    Route::get('/students/{studentId}/points/{type}', [PointController::class, 'getPointsByType']);
    });
    //ADS
    Route::middleware(['auth:sanctum', 'role:guide'])->group(function () {
    Route::get('/ads', [AdController::class, 'index']);
    Route::post('/ads', [AdController::class, 'store']);
    Route::put('/ads', [AdController::class, 'update']);
    Route::delete('/ads', [AdController::class, 'destroy']);
    //notifications
    Route::get('/notifications', [NotificationController::class, 'index']);
    Route::post('/notifications', [NotificationController::class, 'store']);
    Route::put('/notifications', [NotificationController::class, 'update']);
    Route::delete('/notifications', [NotificationController::class, 'destroy']);
});
 Route::middleware(['auth:sanctum', 'can:view-students'])->group(function () {
    Route::get('/students', [StudentController::class, 'index']);
    Route::get('/students/{id}', [StudentController::class, 'show']);
    Route::get('/students/search/by-name', [StudentController::class, 'searchByName']);
});


Route::middleware(['auth'])->group(function () {
    Route::get('/classes', [ClassesController::class, 'index']);
    Route::get('/classes/{id}', [ClassesController::class, 'show']);


    Route::get('/sections', [SectionController::class, 'index']); // للحصول على جميع الأقسام
    Route::get('/sections/{id}', [SectionController::class, 'show']); // للحصول على قسم محدد
});
Route::middleware(['auth'])->group(function () {
    Route::get('/subjects', [SubjectController::class, 'index']); // للحصول على جميع المواد
    Route::get('/subjects/{id}', [SubjectController::class, 'show']); // للحصول على مادة محددة
 });
 Route::middleware(['auth:sanctum', 'role:parent'])->group(function () {
    Route::get('/children', [ParentController::class, 'myChildren']);
    Route::get('/children/{studentId}/grades', [ParentController::class, 'childGrades']);
    Route::get('/children/{studentId}/fees', [ParentController::class, 'childFees']);
    Route::get('/children/{studentId}/points', [ParentController::class, 'childPoints']);
    Route::get('/notifications', [ParentController::class, 'notifications']);
    Route::get('/ads', [ParentController::class, 'ads']);
});
//Accountant
Route::middleware(['auth', 'role:accountant'])->group(function () {
    // عرض كل الأقساط
    Route::get('/fees', [FeeController::class, 'index']);
     // إنشاء قسط جديد لجميع الطلاب في صف معين
    Route::post('/fees', [FeeController::class, 'store']);
        // دفع دفعة واحدة من القسط
     Route::post('/installments/pay/{installmentId}', [FeeController::class, 'payInstallment']);
    // حذف قسط مع دفعاته
    Route::delete('/fees/{id}', [FeeController::class, 'destroy']);
});



});
