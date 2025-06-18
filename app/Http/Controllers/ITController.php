<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Classe; // تأكدي من اسم المودل إذا اسمه Class أو Classe
use App\Models\classes;
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
   public function createClass(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'nullable|string',
            'tuition' => 'nullable|integer',
            'student_count' => 'nullable|integer',
        ]);

        $class = classes::create($validated);
        return response()->json($class, 201);
    }

    public function updateClass(Request $request, $id)
    {
        $class = classes::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'level' => 'nullable|string',
            'tuition' => 'nullable|integer',
            'student_count' => 'nullable|integer',
        ]);
        $class->update($validated);
        return response()->json($class);
    }

    public function deleteClass($id)
    {
        $class = Classes::findOrFail($id);
        $class->delete();
        return response()->json(['message' => 'تم حذف الصف بنجاح']);
    }

    // ✳️ الشعب
    public function createSection(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:school_classes,id',
            'guide_id' => 'nullable|exists:users,id',
        ]);

        $section = Section::create($validated);
        return response()->json($section, 201);
    }

    public function updateSection(Request $request, $id)
    {
        $section = Section::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'class_id' => 'sometimes|exists:school_classes,id',
            'guide_id' => 'nullable|exists:users,id',
        ]);

        $section->update($validated);
        return response()->json($section);
    }

    public function deleteSection($id)
    {
        $section = Section::findOrFail($id);
        $section->delete();
        return response()->json(['message' => 'تم حذف الشعبة بنجاح']);
    }

    // ✳️ المواد
    public function createSubject(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $subject = Subject::create($validated);
        return response()->json($subject, 201);
    }

    public function updateSubject(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $subject->update($validated);
        return response()->json($subject);
    }

    public function deleteSubject($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();
        return response()->json(['message' => 'تم حذف المادة بنجاح']);
    }
}
