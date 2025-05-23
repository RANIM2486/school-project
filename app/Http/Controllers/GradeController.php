<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    // عرض كل العلامات مع الطالب والمادة المرتبطين
    public function index()
    {
        return Grade::with(['student', 'subject'])->get();
    }

    // إضافة علامة جديدة باستخدام Form Request
    public function store(StoreGradeRequest $request)
    {
        $grade = Grade::create($request->validated());
        return response()->json($grade, 201);
    }

    // عرض تفاصيل علامة معينة
    public function show($id)
    {
        return Grade::with(['student', 'subject'])->findOrFail($id);
    }

    // تعديل علامة باستخدام UpdateGradeRequest
    public function update(UpdateGradeRequest $request, $id)
    {
        $grade = Grade::findOrFail($id);
        $grade->update($request->validated());
        return response()->json($grade);
    }

    // حذف علامة
    public function destroy($id)
    {
        Grade::findOrFail($id)->delete();
        return response()->json(['message' => 'تم حذف العلامة بنجاح']);
    }
 }
