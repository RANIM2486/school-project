<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Section;
use App\Models\Student;
use App\Models\User;
use App\Models\Point;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Ad;

class AdminController extends Controller
{
    public function allClasses()
    {
        return response()->json(Classes::all());
    }

    public function allSections()
    {
        return response()->json(Section::all());
    }

    public function allStudents()
    {
        return response()->json(Student::all());
    }

    public function allTeachers()
    {
        return response()->json(User::where('role', 'teacher')->get());
    }

    public function allPoints()
    {
        return response()->json(Point::all());
    }

    public function allSubjects()
    {
        return response()->json(Subject::all());
    }

    public function allGrades()
    {
        return response()->json(Grade::all());
    }

    public function allAds()
    {
        return response()->json(Ad::all());
    }
}
