<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Grade;
use App\Models\Ad;
use App\Models\Point;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\User;
use \App\Models\Notification;
use App\Models\Current_Student;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class GuideController extends Controller
{
    // استعراض الشعب التي يشرف عليها الموجه
    public function mySections()
    {
        // if (Auth::user() && Auth::user()->role !== 'guide') {
        //     return response()->json(['message' => ''], 403);
        // }
        $user = Auth::user();
        $sections = Section::where('guide_id', $user->id)->get();
        return response()->json($sections);
    }

    // استعراض الطلاب في شعبة معينة
    public function studentsInSection($sectionId)
    {
        // if (Auth::user() && Auth::user()->role !== 'guide') {
        //     return response()->json(['message' => ''], 403);
        // }
        $user = Auth::user();
        $section = Section::where('id', $sectionId)
            ->where('guide_id', $user->id)
            ->firstOrFail();
        $students = $section->currentStudents;
        return response()->json($students);
    }

    // إدخال علامة لطالب
    public function addGrade(Request $request)
    {

        $user = Auth::user();
        $validated = $request->validate([
            'student_id'   => 'required|exists:current_students,id',
            'subject_id'   => 'required|exists:subjects,id',
            'exam1'        => 'nullable|numeric|min:0|max:100',
            'exam2'        => 'nullable|numeric|min:0|max:100',
            'exam3'        => 'nullable|numeric|min:0|max:100',
            'quiz'         => 'nullable|integer|min:0|max:100',
            'final_exam'   => 'nullable|numeric|min:0|max:100',
            'date'         => 'nullable|date',
        ]);
        $validated["guide_id"]=$user->id;

        if (!$this->isStudentInGuideSections($validated['student_id'], $user->id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $grade = Grade::where('student_id', $validated['student_id'])
            ->where('subject_id', $validated['subject_id'])
            ->first();

        if ($grade) {
            $grade->update(array_merge($validated, ['guide_id' => $user->id]));
            return response()->json($grade, 200);
        } else {
            $validated['guide_id'] = $user->id;
            $grade = Grade::create($validated);
            return response()->json($grade, 201);
        }
    }

    public function showStudentGrades($student_id)
    {
        $user = Auth::user();

        if (!$this->isStudentInGuideSections($student_id, $user->id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $grades = Grade::where('student_id', $student_id)
            ->with('subject')
            ->get();

        return response()->json($grades);
    }

    public function updateGrade(Request $request, $id)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'exam1'        => 'nullable|numeric|min:0|max:100',
            'exam2'        => 'nullable|numeric|min:0|max:100',
            'exam3'        => 'nullable|numeric|min:0|max:100',
            'quiz'         => 'nullable|numeric|min:0|max:100',
            'final_exam'   => 'nullable|numeric|min:0|max:100',
            'date'         => 'nullable|date',
        ]);
        $validated["guide_id"]=$user->id;
        $grade = Grade::findOrFail($id);

        if (!$this->isStudentInGuideSections($grade->student_id, $user->id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $grade->update($validated);

        return response()->json($grade, 200);
    }

    public function deleteGrade($id)
    {
        $user = Auth::user();
        $grade = Grade::findOrFail($id);

        if (!$this->isStudentInGuideSections($grade->student_id, $user->id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $grade->delete();

        return response()->json(['message' => 'Grade deleted successfully']);
    }

    public function getGrades()
    {
        $user = Auth::user();
        $studentIds = $this->getGuideStudentIds($user->id);


    $grades = Grade::whereIn('student_id', $studentIds)
            ->with(['student', 'subject'])
            ->get();

        return response()->json($grades);
    }

    public function addAttendance(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'student_id' => 'required|exists:current_students,id',
            'status' => 'required|in:موجود,غير موجود',
            'attendance_date' => 'nullable|date',
        ]);

        $student = Current_Student::with('parent')->findOrFail($validated['student_id']);

        if (!$this->isStudentInGuideSections($validated['student_id'], $user->id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $date = $validated['attendance_date'] ?? Carbon::now()->toDateString();

        $attendance = Attendance::updateOrCreate(
            ['student_id' => $student->id, 'attendance_date' => $date],
            ['guide_id' => Auth::id(), 'status' => $validated['status']]
        );

        if ($validated['status'] === 'غير موجود' && $student->parent)
        {
            $this->notifyParent(
                $student->parent->id,
                'غياب الطالب',
                "تم تسجيل غياب للطالب {$student->name} بتاريخ {$date}."
            );
        }

        return response()->json($attendance, 201);
    }

    // دالة مساعدة: تحقق إن الطالب ضمن شعب الموجه
    private function isStudentInGuideSections($studentId, $guideId)
    {
        return Current_Student::where('id', $studentId)
            ->whereHas('section', function ($query) use ($guideId) {
                $query->where('guide_id', $guideId);
            })->exists();
    }

    private function getGuideStudentIds($guideId)
    {
        return Current_Student::whereHas('section', function ($query) use ($guideId) {
            $query->where('guide_id', $guideId);
        })->pluck('id');
    }

    private function notifyParent($userId, $title, $content)
    {
        Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'content' => $content,
        ]);
    }
}

