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
use Carbon\Carbon;
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
            'current_student_id' => 'required|exists:current_students,id',
            'type' => 'required|in:positive,negative',
            'value' => 'required|integer',
            'note' => 'nullable|string',
        ]);

        $point = Point::create([
            'current_student_id' => $validated['current_student_id'],
            'reason_id' => $validated['reason_id'],
            'type' => $validated['type'],
            'value' => $validated['value'],
            'note' => $validated['note'],
            //'given_by' => Auth::user()->id,
            'teacher_id' => Auth::id(),
        ]);

        return response()->json($point, 201);
    }

    // إضافة علامة لطالب

    // إضافة ملاحظة لطالب


public function addNote(Request $request)
{

    $validated = $request->validate([
        'current_student_id' => 'required|exists:current_students,id',
        'content' => 'required|string',
        'title'=>'required|string',
    ]);

    $note = comment::create([
        'current_student_id' => $validated['current_student_id'],
           'title'=>$validated['title'],
        'content' => $validated['content'],
        'added_by' => Auth::user()->id,
        'user_id' => Auth::user()->id,
        'name' => Auth::user()->name,
        'date' => Carbon::now(), // إضافة التاريخ الحالي
    ]);

    return response()->json($note, 201);
}


}
