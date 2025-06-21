<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurrentStudentRequest;
use App\Http\Requests\UpdateCurrentStudentRequest;
use App\Models\classes;
use App\Models\Current_Student;
use App\Models\CurrentStudent;

class CurrentStudentController extends Controller
{
    public function store(StoreCurrentStudentRequest $request)
    {
        // إنشاء الطالب الحالي باستخدام create
        $currentStudent = CurrentStudent::create([
            'student_id' => $request->student_id,
            'section_id' => $request->section_id,
            'semester_id' => $request->semester_id,
            'class_id' => $request->class_id,
            'status' => $request->status,
        ]);

        // تحديث عدد الطلاب في الصف
        $class = classes::find($request->class_id);
        $class->student_count += 1;
        $class->save();

        return response()->json([
            'message' => 'تمت إضافة الطالب بنجاح',
            'data' => $currentStudent
        ], 201);
    }

    public function destroy($id)
    {
        $currentStudent = CurrentStudent::findOrFail($id);
        $class =classes::find($currentStudent->class_id);

        // حذف الطالب
        $currentStudent->delete();

        // تقليل عدد الطلاب في الصف
        if ($class && $class->student_count > 0) {
            $class->student_count -= 1;
            $class->save();
        }

        return response()->json(['message' => 'تم حذف الطالب الحالي بنجاح']);
    }

    public function index()
    {
        $students = CurrentStudent::with(['student', 'section','class'])->get();
        return response()->json($students);
    }

    public function show($id)
    {
        $student = CurrentStudent::with(['student', 'section', 'class'])->findOrFail($id);
        return response()->json($student);
    }

      public function countActive()
    {
        return response()->json(['active' => CurrentStudent::countActive()]);
    }

    public function countPostponed()
    {
        return response()->json(['postponed' => CurrentStudent::countPostponed()]);
    }

    public function countLeft()
    {
        return response()->json(['left' => CurrentStudent::countLeft()]);
    }

        public function countBySection($sectionid)
    {
        return response()->json(['section_id' => $sectionid, 'count' => CurrentStudent::countBySection($sectionid)]);
    }

        public function countByClass($classId)
    {
        return response()->json(['class_id' => $classId, 'count' => CurrentStudent::countByClass($classId)]);
    }
}

