<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClassRequest;
use App\Http\Requests\UpdateClassRequest;
use App\Models\classes;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    // عرض كل الصفوف
    public function index()
    {

        return response()->json(classes::all());
    }

    // إضافة صف جديد
    public function store(StoreClassRequest $request)
    {
        $class = classes::create($request->validated());
        return response()->json(['message'=>'تم إنشاء الصف بنجاح',$class], 201);
    }

    // عرض صف محدد
    public function show($id)
    {
        $class=classes::findorFail($id);
        return response()->json($class);

    }

    // تعديل صف
    public function update(UpdateClassRequest $request, $id)
    {
        $class = classes::findOrFail($id);
        $class->update($request->validated());
        return response()->json(['message'=>'تم تعديل الصف بنجاح'],$class);
    }

    // حذف صف
    public function destroy($id)
    {
        classes::findOrFail($id)->delete();
        return response()->json(['message' => 'تم حذف الصف بنجاح']);
    }
}
