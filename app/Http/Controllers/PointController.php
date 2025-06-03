<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Point;
use App\Models\Reason;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class PointController extends Controller
{
    public function index()
    {
        try {
            return Point::with(['student', 'teacher', 'reason'])->get();
        } catch (\Exception $e) {
            return response()->json(['message' => 'خطأ أثناء جلب البيانات', 'error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $user = Auth::user(); // فقط للحصول على ID المعلم الحالي

            $validated = $request->validate([
                'student_id' => 'required|exists:students,id',
                'reason_id' => 'required|exists:reasons,id',
            ]);

            $point = Point::create([
                'student_id' => $validated['student_id'],
                'teacher_id' => $user->id,
                'reason_id' => $validated['reason_id'],
            ]);

            return response()->json($point->load(['student', 'teacher', 'reason']), 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'التحقق من البيانات فشل', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'حدث خطأ أثناء الحفظ', 'error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $point = Point::with(['student', 'teacher', 'reason'])->findOrFail($id);
            return response()->json($point);
        } catch (\Exception $e) {
            return response()->json(['message' => 'لم يتم العثور على النقطة', 'error' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $point = Point::findOrFail($id);

            $validated = $request->validate([
                'student_id' => 'exists:students,id',
                'reason_id' => 'exists:reasons,id',
            ]);

            $point->update($request->only(['student_id', 'reason_id']));

            return response()->json($point->load(['student', 'teacher', 'reason']));

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['message' => 'التحقق من البيانات فشل', 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['message' => 'حدث خطأ أثناء التحديث', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $point = Point::findOrFail($id);
            $point->delete();

            return response()->json(['message' => 'تم الحذف بنجاح']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'حدث خطأ أثناء الحذف', 'error' => $e->getMessage()], 500);
        }
    }

    public function getStudentPoints($studentId)
    {
        try {
            $points = Point::with(['reason', 'teacher'])
                ->where('student_id', $studentId)
                ->get();

            return response()->json($points);
        } catch (\Exception $e) {
            return response()->json(['message' => 'خطأ في جلب النقاط', 'error' => $e->getMessage()], 500);
        }
    }

    public function getStudentTotalPoints($studentId)
    {
        try {
            $points = Point::with('reason')->where('student_id', $studentId)->get();

            $total = 0;
            foreach ($points as $point) {
                $value = $point->reason->value;
                $total += $point->reason->type === 'positive' ? $value : -$value;
            }

            return response()->json([
                'student_id' => $studentId,
                'total_points' => $total
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'خطأ في حساب مجموع النقاط', 'error' => $e->getMessage()], 500);
        }
    }
    public function getPointsByType($studentId, $type)
    {
        try {
            $points = Point::with('reason')
                ->where('student_id', $studentId)
                ->whereHas('reason', function ($q) use ($type) {
                    $q->where('type', $type); // 'positive' or 'negative'
                })
                ->get();

            return response()->json($points);
        } catch (\Exception $e) {
            return response()->json(['message' => 'خطأ في جلب النقاط حسب النوع', 'error' => $e->getMessage()], 500);
        }
    }
}
