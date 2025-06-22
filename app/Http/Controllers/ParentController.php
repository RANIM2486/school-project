<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Grade;
use App\Models\Fee;
use App\Models\Notification;
use App\Models\Ad;
use App\Models\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParentController extends Controller
{
    // استعراض جميع الأبناء مع معلومات الصف والشعبة
    public function myChildren()
    {
        $children = Student::where('parent_id', Auth::id())->with(['class', 'section'])->get();
        return response()->json($children);
    }

    // استعراض علامات ابن معين
    public function childGrades($studentId)
    {
        $student = $this->verifyOwnership($studentId);
        return response()->json($student->grades);
    }

    // استعراض أقساط ابن معين
    public function childFees($studentId)
    {
        $student = $this->verifyOwnership($studentId);
        return response()->json($student->fees);
    }

    // استعراض نقاط ابن معين
    public function childPoints($studentId)
    {
        $student = $this->verifyOwnership($studentId);
        return response()->json($student->points);
    }

    // استعراض كل الإشعارات
    public function notifications()
    {
         $notifications = Notification::where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        return response()->json($notifications);
    }

    // استعراض كل الإعلانات
    public function ads()
    {
        return response()->json(Ad::all());
    }

    // حماية: تحقق أن الطالب يعود لهذا الأب
    private function verifyOwnership($studentId)
    {
        return Student::where('id', $studentId)->where('parent_id', Auth::id())->firstOrFail();
    }
}
