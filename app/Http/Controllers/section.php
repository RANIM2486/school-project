<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
   // ✅ عرض كل الشعب (متاح فقط للمدير)
    public function index()
    {
        return response()->json(Section::all());
    }

    // ✅ عرض شعبة محددة
    public function show($id)
    {
        $section = Section::findOrFail($id);
        return response()->json($section);
    }

    // ✅ إنشاء شعبة جديدة (متاح لـ IT فقط)
    public function store(StoreSectionRequest $request)
    {
        $section = Section::create($request->validated());
        return response()->json(['message' => 'تم إنشاء الشعبة بنجاح', 'data' => $section], 201);
    }

    // ✅ تعديل شعبة (متاح لـ IT فقط)
    public function update(UpdateSectionRequest $request, $id)
    {
        $section = Section::findOrFail($id);
        $section->update($request->validated());
        return response()->json(['message' => 'تم تعديل الشعبة بنجاح', 'data' => $section]);
    }

    // ✅ حذف شعبة (متاح لـ IT فقط)
    public function destroy($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();
        return response()->json(['message' => 'تم حذف الشعبة بنجاح']);
    }

}
