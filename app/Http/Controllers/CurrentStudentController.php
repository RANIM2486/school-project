<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCurrentStudentRequest;
use App\Http\Requests\UpdateCurrentStudentRequest;
use App\Models\Current_Student;

class CurrentStudentController extends Controller
{
    public function index()
    {
        return Current_Student::with(['student', 'class', 'section'])->get();
    }

    public function store(StoreCurrentStudentRequest $request)
    {
        return Current_Student::create($request->validated());
    }

    public function show($id)
    {
        return Current_Student::with(['student', 'class', 'section'])->findOrFail($id);
    }

    public function update(UpdateCurrentStudentRequest $request, $id)
    {
        $currentStudent = Current_Student::findOrFail($id);
        $currentStudent->update($request->validated());
        return $currentStudent;
    }

    public function destroy($id)
    {
        return Current_Student::destroy($id);
    }
}
