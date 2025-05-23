<?php

namespace App\Http\Controllers;

 use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // عرض كل المواد مع المعلم المسؤول
    public function index()
    {
        return Subject::with('teacher')->get();
    }

    // إضافة مادة جديدة باستخدام Form Request
    public function store(StoreSubjectRequest $request)
    {
        $subject = Subject::create($request->validated());
        return response()->json($subject, 201);
    }

    // عرض تفاصيل مادة واحدة
    public function show($id)
    {
        return Subject::with('teacher')->findOrFail($id);
    }

    // تعديل بيانات مادة
    public function update(UpdateSubjectRequest $request, $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->update($request->validated());
        return response()->json($subject);
    }

    // حذف مادة
    public function destroy($id)
    {
        Subject::findOrFail($id)->delete();
        return response()->json(['message' => 'تم حذف المادة بنجاح']);
    }
 }
