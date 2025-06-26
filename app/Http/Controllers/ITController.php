<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreClassRequest;
use App\Http\Requests\UpdateClassRequest;
use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
//use App\Http\Requests\StoreStudentRequest;
//use App\Http\Requests\UpdateStudentRequest;
use App\Models\Bus;
use App\Models\User;
use App\Models\Section;
use App\Models\Subject;
use App\Models\classes;
use App\Models\student;
use App\Models\Current_Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ITController extends Controller
{
    // 🧑‍💻 إنشاء حساب مستخدم (ما عدا المدير)
   public function createUser(Request $request)
{
    // تحقق مما إذا كان المستخدم مسجل الدخول ولديه دور "IT"
    if (!Auth::user() || Auth::user()->role !== 'it') {
        return response()->json(['message' => 'ليس لديك الصلاحيات لإنشاء حسابات'], 403);
    }

    // public function createUser(Request $request)
    // {
    //      if ( Auth::user()->role === 'it') {


        // $validated = $request->validate([
        //     'name' => 'required|string|max:255',
        //     'email' => 'required|email|unique:users,email',
        //     'password' => 'required|string|min:6',
        //     'role' => 'required|in:admin,teacher,guide,it,parent,accountant',
        // ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:teacher,guide,parent,accountant', // استثنينا "admin"
        ]);

    // إنشاء المستخدم الجديد
    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => $validated['role'],
    ]);

    return response()->json($user, 201);
}


// 🏫 الشعب
  public function createClass(StoreClassRequest $request)
    {
        $class = classes::create($request->validated());
        return response()->json($class, 201);
    }

    public function updateClass(UpdateClassRequest $request, $id)
    {
        $class = classes::findOrFail($id);
        $class->update($request->validated());
        return response()->json($class);
    }

    public function deleteClass($id)
    {
        $class = classes::findOrFail($id);
        $class->delete();
        return response()->json(['message' => 'تم حذف الصف بنجاح']);
    }

    // الشعب
    public function createSection(StoreSectionRequest $request)
    {
        $section = Section::create($request->validated());
        return response()->json($section, 201);
    }

    public function updateSection(UpdateSectionRequest $request, $id)
    {
        $section = Section::findOrFail($id);
        $section->update($request->validated());
        return response()->json($section);
    }

    public function deleteSection($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();
        return response()->json(['message' => 'تم حذف الشعبة بنجاح']);
    }

    // المواد
    public function createSubject(StoreSubjectRequest $request)
    {
        $subject = Subject::create($request->validated());
        return response()->json($subject, 201);
    }

    public function updateSubject(UpdateSubjectRequest $request, $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->update($request->validated());
        return response()->json($subject);
    }

    public function deleteSubject($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return response()->json(['message' => 'تم حذف المادة بنجاح']);
    }

    // الطلاب
    public function createStudent(Request $request)
    {
          $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'father_name' => 'required|string|max:255',
        'mother_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'gender' => 'required|in:ذكر,أنثى',
        'birth_date' => 'required|date',
        'address' => 'nullable|string|max:255',
        'entry_date' => 'required|date',
        'class_id' => 'required|exists:classes,id',
        'section_id' => 'required|exists:sections,id',
        'parent_id' => 'required|exists:users,id',
    ]);

    $student = Student::create($validated);

    // إنشاء الطالب الحالي
    $student->current()->create([
        'class_id' => $student->class_id,
        'section_id' => $student->section_id,
        'status' => 'مستمر',
    ]);

    // تحديث الصف
    $class = Classes::find($student->class_id);
    if ($class) {
        $class->students_count += 1;
        $class->save();
    }
    return response()->json(['message' => 'Student created successfully'], 201);
    }
    public function updateStudent(Request $request,$id)
    {
          // التحقق من صحة البيانات
    $validated = $request->validate([
        'first_name'   => 'required|string|max:255',
        'father_name'  => 'required|string|max:255',
        'mother_name'  => 'required|string|max:255',
        'last_name'    => 'required|string|max:255',
        'gender'       => 'required|in:ذكر,أنثى',
        'birth_date'   => 'required|date',
        'address'      => 'nullable|string|max:255',
        'entry_date'   => 'required|date',
        'class_id'     => 'required|exists:classes,id',
        'section_id'   => 'required|exists:sections,id',
        'parent_id'    => 'required|exists:users,id',
    ]);

    // جلب الطالب
    $student = Student::findOrFail($id);
    $oldClassId = $student->class_id;

    // تحديث بيانات الطالب
    $student->update($validated);

    // تحديث أو إنشاء سجل الطالب الحالي
    $student->current()->updateOrCreate(
        ['student_id' => $student->id],
        [
            'class_id'   => $student->class_id,
            'section_id' => $student->section_id,
            'status'     => 'مستمر',
        ]
    );

    // إذا تغير الصف، حدّث أعداد الطلاب
    if ($oldClassId != $student->class_id) {
        $oldClass = Classes::find($oldClassId);
        if ($oldClass && $oldClass->student_count > 0) {
            $oldClass->students_count -= 1;
            $oldClass->save();
        }

        $newClass = Classes::find($student->class_id);
        if ($newClass) {
            $newClass->student_count += 1;
            $newClass->save();
        }
    }
    return response()->json(['message' => 'تم تعديل الطالب بنجاح']);
    }

    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $currentStudent = Current_Student::findOrFail($id);
         $class =classes::find($currentStudent->class_id);

        $student->delete();
                // تقليل عدد الطلاب في الصف
        if ($class && $class->student_count > 0) {
            $class->student_count -= 1;
            $class->save();
        }
        return response()->json(['message' => 'تم حذف الطالب بنجاح']);
    }
    public function createBus(Request $request)
{
    $validated = $request->validate([
        'driver_name' => 'required|string|max:100',
        'area' => 'required|string|max:20',
        'phone' => 'required|integer|min:1',
    ]);

    $bus = Bus::create($validated);
    return response()->json([
        'message' => 'تم إنشاء الباص بنجاح',
        'data' => $bus
    ], 201);
}

public function updateBus(Request $request, $id)
{
    $bus = Bus::findOrFail($id);

    $validated = $request->validate([
        'driver_name' => 'sometimes|string|max:100',
        'area' => 'sometimes|string|max:20',
        'phone' => 'sometimes|integer|min:1',
    ]);

    $bus->update($validated);
    return response()->json([
        'message' => 'تم تعديل بيانات الباص بنجاح',
        'data' => $bus
    ]);
}

public function deleteBus($id)
{
    $bus = Bus::findOrFail($id);
    $bus->delete();
    return response()->json(['message' => 'تم حذف الباص بنجاح']);
}
}
