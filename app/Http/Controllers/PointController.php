<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Point;
use App\Models\Reason;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class PointController extends Controller
{

    // عرض جميع النقاط
    public function index()
    {
        // التحقق من توكن المستخدم الحالي
        $user = Auth::user();

        // يمكنك إضافة عمليات أخرى بناءً على دور المستخدم (مثل: المعلم أو الأهل)
        return Point::with(['student', 'teacher', 'reason'])->get();
    }

    // إنشاء نقطة جديدة
    public function store(Request $request)
    {
        // التحقق من التوثيق بواسطة Sanctum
        $user = Auth::user();  // المستخدم الحالي الذي تم توثيقه عبر التوكن

        // تحقق من الصلاحيات (مثلاً: فقط المعلم يمكنه إضافة نقطة)
        if ($user->role !== 'teacher') {
            return response()->json(['message' => 'You are not authorized to add points'], 403);
        }

        // التحقق من البيانات المدخلة
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'reason_id' => 'required|exists:reasons,id',
        ]);

        // تحديد السبب وإضافة النقطة
        $reason = Reason::find($request->reason_id);

        $point = Point::create([
            'student_id' => $request->student_id,
            'teacher_id' => $user->id,  // أخذ المعلم الذي قام بتسجيل النقطة
            'reason_id' => $reason->id,
            'date' => now(),
        ]);

        return response()->json($point->load(['student', 'teacher', 'reason']), 201);
    }

    // عرض نقطة واحدة
    public function show($id)
    {
        $point = Point::with(['student', 'teacher', 'reason'])->findOrFail($id);
        return response()->json($point);
    }

    // تحديث نقطة
    public function update(Request $request, $id)
    {
        $point = Point::findOrFail($id);

        // تحقق من صلاحيات المعلم
        $user = Auth::user();
        if ($user->role !== 'teacher') {
            return response()->json(['message' => 'You are not authorized to update this point'], 403);
        }

        // التحقق من البيانات المدخلة
        $request->validate([
            'student_id' => 'exists:students,id',
            'reason_id' => 'exists:reasons,id',
        ]);

        $point->update($request->only(['student_id', 'teacher_id', 'reason_id']));

        return response()->json($point->load(['student', 'teacher', 'reason']));
    }

    // حذف نقطة
    public function destroy($id)
    {
        $point = Point::findOrFail($id);

        // تحقق من صلاحيات المعلم
        $user = Auth::user();
        if ($user->role !== 'teacher') {
            return response()->json(['message' => 'You are not authorized to delete this point'], 403);
        }

        $point->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }

}
