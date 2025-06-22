<?php

namespace App\Http\Controllers;

 use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
     public function index()
    {
        $students = Student::with(['class', 'section'])->get();
        return response()->json($students);
    }

     public function show($id)
    {
        $student = Student::with(['class', 'section'])->findOrFail($id);
        return response()->json($student);
    }
      public function searchByName(Request $request)
    {
        $name = $request->input('name');

        $students = Student::with(['class', 'section'])
            ->where('first_name', 'like', "%{$name}%")
            ->orWhere('last_name', 'like', "%{$name}%")
            ->get();

        return response()->json($students);
    }
}
