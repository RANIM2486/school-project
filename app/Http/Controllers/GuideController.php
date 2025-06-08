<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Student;
use App\Models\Grade;
use App\Models\Ad;
use App\Models\Point;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GuideController extends Controller
{
    // استعراض الشعب التي يشرف عليها الموجه
    public function mySections()
    {
        $user = Auth::user();


        $sections = Section::where('guide_id', $user->id)->get();
        return response()->json($sections);
    }

    // استعراض الطلاب في شعبة معينة
    public function studentsInSection($sectionId)
    {
        $user = Auth::user();


        $section = Section::where('id', $sectionId)
            ->where('guide_id', $user->id)
            ->firstOrFail();

        $students = $section->students;
        return response()->json($students);
    }

    // إدخال علامة لطالب
    public function addGrade(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:100',
        ]);

        if (!$this->isStudentInGuideSections($validated['student_id'], $user->id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $grade = Grade::create($validated);
        return response()->json($grade, 201);
    }

    // نشر إعلان
    public function postAd(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $ad = Ad::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'posted_by' => $user->id,
        ]);

        return response()->json($ad, 201);
    }

    // إضافة نقاط لطالب
    public function givePoint(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|in:positive,negative',
            'value' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        if (!$this->isStudentInGuideSections($validated['student_id'], $user->id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $point = Point::create([
            'student_id' => $validated['student_id'],
            'type' => $validated['type'],
            'value' => $validated['value'],
            'note' => $validated['note'],
            'given_by' => $user->id,
        ]);

        return response()->json($point, 201);
    }

    // تسجيل حضور أو غياب
    public function markAttendance(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent',
        ]);

        if (!$this->isStudentInGuideSections($validated['student_id'], $user->id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $attendance = Attendance::updateOrCreate(
            ['student_id' => $validated['student_id'], 'date' => $validated['date']],
            ['status' => $validated['status']]
        );

        return response()->json($attendance);
    }

    // دالة مساعدة: تحقق إن الطالب ضمن شعب الموجه
    private function isStudentInGuideSections($studentId, $guideId)
    {
        return Student::where('id', $studentId)
            ->whereHas('section', function ($query) use ($guideId) {
                $query->where('guide_id', $guideId);
            })->exists();
    }
}
