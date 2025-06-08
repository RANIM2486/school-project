<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\comment;
use App\Models\Section;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Point;
use App\Models\Note;
use App\Models\SubjectTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{
    // استعراض الصفوف التي يدرسها المعلم
    public function myClasses()
    {
        $teacherId = Auth::user()->id;

        $classes = Classes::whereHas('subjectsTeachers', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->get();

        return response()->json($classes);
    }

    // استعراض الشعب التي يدرسها المعلم
    public function mySections()
    {
        $teacherId = Auth::user()->id;

        $sections = Section::whereHas('subjectsTeachers', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->get();

        return response()->json($sections);
    }

    // استعراض الطلاب في شعبة معينة
    public function studentsInSection($sectionId)
    {
        $section = Section::findOrFail($sectionId);

        return response()->json($section->students);
    }

    // استعراض المواد التي يدرسها المعلم
    public function mySubjects()
    {
        $teacherId = Auth::user()->id;

        $subjects = Subject::whereHas('subjectsTeachers', function ($query) use ($teacherId) {
            $query->where('teacher_id', $teacherId);
        })->get();

        return response()->json($subjects);
    }

    // إعطاء نقطة لطالب
    public function givePoint(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'type' => 'required|in:positive,negative',
            'value' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $point = Point::create([
            'student_id' => $validated['student_id'],
            'type' => $validated['type'],
            'value' => $validated['value'],
            'note' => $validated['note'],
            'given_by' => Auth::user()->id,
        ]);

        return response()->json($point, 201);
    }

    // إضافة علامة لطالب
    public function addGrade(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:100',
        ]);

        $grade = Grade::create($validated);

        return response()->json($grade, 201);
    }

    // إضافة ملاحظة لطالب
    public function addNote(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'content' => 'required|string',
        ]);

        $note = comment::create([
            'student_id' => $validated['student_id'],
            'content' => $validated['content'],
            'added_by' => Auth::user()->id,
        ]);

        return response()->json($note, 201);
    }
}
