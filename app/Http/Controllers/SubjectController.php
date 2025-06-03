<?php

namespace App\Http\Controllers;

 use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{

    // ✔️ للمدير
    public function index()
    {
        return response()->json(Subject::all());
    }

    // ✔️ إنشاء مادة (IT)
    public function store(StoreSubjectRequest $request)
    {
        $subject = Subject::create($request->validated());
        return response()->json([
            'message' => 'تم إنشاء المادة بنجاح',
            'data' => $subject
        ], 201);
    }

    // ✔️ عرض مادة واحدة
    public function show($id)
    {
        return response()->json(Subject::findOrFail($id));
    }

    // ✔️ تعديل (IT)
    public function update(UpdateSubjectRequest $request, $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->update($request->validated());

        return response()->json([
            'message' => 'تم التحديث بنجاح',
            'data' => $subject
        ]);
    }

    // ✔️ حذف (IT)
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return response()->json(['message' => 'تم حذف المادة']);
    }
}
