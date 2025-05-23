<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassRequest;
use App\Http\Requests\UpdateClassRequest;
use App\Models\classes;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class SchoolClassController extends Controller
{
    // عرض كل الصفوف
    public function index()
    {
        return classes::all();
    }

    // إضافة صف جديد
    public function store(StoreClassRequest $request)
    {
        $class = classes::create($request->validated());
        return response()->json($class, 201);
    }

    // عرض صف محدد
    public function show($id)
    {
        return classes::findOrFail($id);
    }

    // تعديل صف
    public function update(UpdateClassRequest $request, $id)
    {
        $class = classes::findOrFail($id);
        $class->update($request->validated());
        return response()->json($class);
    }

    // حذف صف
    public function destroy($id)
    {
        classes::findOrFail($id)->delete();
        return response()->json(['message' => 'تم حذف الصف بنجاح']);
    }
}
