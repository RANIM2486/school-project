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
use \App\Models\Notification;
use App\Models\Current_Student;
use App\Models\CurrentStudent;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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
            'student_id'   => 'required|exists:current_students,id',
            'subject_id'   => 'required|exists:subjects,id',
            'exam1'        => 'nullable|numeric|min:0|max:100',
            'exam2'        => 'nullable|numeric|min:0|max:100',
            'exam3'        => 'nullable|numeric|min:0|max:100',
            'quiz'         => 'nullable|numeric|min:0|max:100',
            'final_exam'   => 'nullable|numeric|min:0|max:100',
            'date'         => 'nullable|date',
        ]);

        if (!$this->isStudentInGuideSections($validated['student_id'], $user->id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // ابحث عن سجل سابق للطالب في نفس المادة
        $grade = Grade::where('student_id', $validated['student_id'])
                    ->where('subject_id', $validated['subject_id'])
                    ->first();

        if ($grade) {
            // إذا وجد، قم بتحديثه
            $grade->update($validated);
            return response()->json($grade, 200); // 200 تعني تم التحديث
        } else {
            // إذا لم يوجد، قم بإنشائه
            $grade = Grade::create($validated);
            return response()->json($grade, 201); // 201 تعني تم الإنشاء
        }
    }
    public function showStudentGrades($student_id)
    {
        $user = Auth::user();

        // التحقق من الصلاحية
        if (!$this->isStudentInGuideSections($student_id, $user->id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // جلب العلامات
        $grades = Grade::where('student_id', $student_id)
                    ->with('subject') // جلب معلومات المادة
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

        $grade = Grade::findOrFail($id);

        // تحقق من صلاحية المرشد للتعديل
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

     // تحقق أن الطالب ضمن أقسام هذا المرشد
        if (!$this->isStudentInGuideSections($grade->student_id, $user->id)) {
            return response()->json(['error' => 'Unauthorized'], 403);
         }

        $grade->delete();

        return response()->json(['message' => 'Grade deleted successfully']);
    }

        public function getGrades()
        {
            $user = Auth::user();

            // جلب IDs الطلاب المرتبطين بالمرشد
            $studentIds = $this->getGuideStudentIds($user->id);

            // جلب العلامات لهؤلاء الطلاب
            $grades = Grade::whereIn('student_id', $studentIds)
                        ->with(['student', 'subject']) // في حال أردت عرض اسم الطالب أو المادة
                        ->get();

            return response()->json($grades);
        }

        public function addAttendance(Request $request)
        {
            $user = Auth::user();
            $validated = $request->validate([
                'student_id' => 'required|exists:current_students,id',
                'status'     => 'required|in:موجود,غير موجود',
                'attendance_date' => 'nullable|date',
            ]);


            $student = Student::with('student.parent')->findOrFail($validated['student_id']);



            if (!$this->isStudentInGuideSections($validated['student_id'], $user->id)) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            $date = $validated['attendance_date'] ?? Carbon::now()->toDateString();

            $attendance = Attendance::updateOrCreate(
                ['student_id' => $student->id, 'attendance_date' => $date],
                ['guide_id' => Auth::id(), 'status' => $validated['status']]
            );

            // إشعار لولي الأمر في حال الغياب
            if ($validated['status'] === 'غير موجود' && $student->student && $student->student->parent_id) {
                $this->notifyParent(
                    $student->student->parent_id,
                    'غياب الطالب',
                    "تم تسجيل غياب للطالب {$student->student->name} بتاريخ {$date}."
                );
        }

        return response()->json($attendance, 201);
    }

    // دالة مساعدة: تحقق إن الطالب ضمن شعب الموجه
    private function isStudentInGuideSections($studentId, $guideId)
    {
        return Student::where('id', $studentId)
            ->whereHas('section', function ($query) use ($guideId) {
                $query->where('guide_id', $guideId);
            })->exists();
    }
    private function getGuideStudentIds($guideId)
    {

        return CurrentStudent::whereHas('section', function ($query) use ($guideId) {

        return Student::whereHas('section', function ($query) use ($guideId) {

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

