<?php

namespace App\Http\Controllers;

use App\Models\classes;
use App\Models\SchoolClass;

class ClassesController extends Controller
{
     public function index()
    {
        return response()->json(Classes::all());
    }

     public function show($id)
    {
        $class = classes::findOrFail($id);
        return response()->json($class);
    }
}
