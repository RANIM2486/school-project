<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreClassRequest;
use App\Http\Requests\UpdateClassRequest;
use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Bus;
use App\Models\User;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Classe; // تأكدي من اسم المودل إذا اسمه Class أو Classe
use App\Models\classes;
use App\Models\student;
use Illuminate\Support\Facades\Hash;

class ITController extends Controller
{
    // 🧑‍💻 إنشاء حساب مستخدم (ما عدا المدير)
    public function createUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:student,teacher,guide,it',
        ]);

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
    public function createStudent(StoreStudentRequest $request)
    {
        $student = Student::create($request->validated());
        return response()->json([
            'message' => 'تم إنشاء الطالب بنجاح',
            'data' => $student
        ], 201);
    }

    public function updateStudent(UpdateStudentRequest $request, $id)
    {
        $student = Student::findOrFail($id);
        $student->update($request->validated());
        return response()->json([
            'message' => 'تم تعديل بيانات الطالب بنجاح',
            'data' => $student
        ]);
    }

    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(['message' => 'تم حذف الطالب بنجاح']);
    }
    public function createBus(Request $request)
{
    $validated = $request->validate([
        'bus_number' => 'required|string|max:50',
        'driver_name' => 'required|string|max:100',
        'driver_phone' => 'required|string|max:20',
        'capacity' => 'required|integer|min:1',
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
        'bus_number' => 'sometimes|string|max:50',
        'driver_name' => 'sometimes|string|max:100',
        'driver_phone' => 'sometimes|string|max:20',
        'capacity' => 'sometimes|integer|min:1',
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
