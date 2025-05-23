<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // عرض كل الطلاب مع الصف والشعبة المرتبطين
    public function index()
    {
        return Student::with(['class', 'section'])->get();
    }

    // إضافة طالب جديد باستخدام Form Request للتحقق
    public function store(StoreStudentRequest $request)
    {
        $student = Student::create($request->validated());
        return response()->json($student, 201);
    }

    // عرض تفاصيل طالب معين
    public function show($id)
    {
        return Student::with(['class', 'section'])->findOrFail($id);
    }

    // تعديل بيانات طالب باستخدام UpdateStudentRequest
    public function update(UpdateStudentRequest $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->validated());
        return response()->json($student);
    }

    // حذف طالب
    public function destroy($id)
    {
        Student::findOrFail($id)->delete();
        return response()->json(['message' => 'تم حذف الطالب بنجاح']);
    }
 }
