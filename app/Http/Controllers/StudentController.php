<?php

namespace App\Http\Controllers;

 use App\Models\Student;

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
}
