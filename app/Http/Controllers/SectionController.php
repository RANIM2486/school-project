<?php

namespace App\Http\Controllers;

 use App\Models\Section;

class SectionController extends Controller
{
     public function index()
    {
        return response()->json(Section::all());
    }

     public function show($id)
    {
        $section = Section::findOrFail($id);
        return response()->json($section);
     }
}
