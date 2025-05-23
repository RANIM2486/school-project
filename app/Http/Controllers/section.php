<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    // عرض كل الشعب مع الصف المرتبط
    public function index()
    {
        return Section::with('class')->get();
    }

    // إضافة شعبة جديدة
    public function store(StoreSectionRequest $request)
    {
        $section = Section::create($request->validated());
        return response()->json($section, 201);
    }

    // عرض شعبة واحدة
    public function show($id)
    {
        return Section::with('class')->findOrFail($id);
    }

    // تعديل شعبة
    public function update(UpdateSectionRequest $request, $id)
    {
        $section = Section::findOrFail($id);
        $section->update($request->validated());
        return response()->json($section);
    }

    // حذف شعبة
    public function destroy($id)
    {
        Section::findOrFail($id)->delete();
        return response()->json(['message' => 'تم حذف الشعبة بنجاح']);
    }
}
