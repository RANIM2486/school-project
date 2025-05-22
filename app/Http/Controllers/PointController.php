<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Point;

class PointController extends Controller
{
        public function index()
    {
        return Point::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'teacher_id' => 'required|exists:teachers,id',
            'points' => 'required|integer',
        ]);

        $point = Point::create($validated);
        return response()->json($point, 201);
    }
}
