<?php

namespace App\Http\Controllers;

 use App\Models\Subject;

class SubjectController extends Controller
{
     public function index()
    {
        return response()->json(Subject::all());
    }

     public function show($id)
    {
         $subject = Subject::findOrFail($id);
        return response()->json($subject);
     }
}
