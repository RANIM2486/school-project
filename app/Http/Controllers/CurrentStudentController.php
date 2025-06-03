<?php

namespace App\Http\Controllers;

use App\Models\CurrentStudent;
use App\Http\Requests\StoreCurrentStudentRequest;
use App\Http\Requests\UpdateCurrentStudentRequest;

class CurrentStudentController extends Controller
{
    public function index()
    {
        return CurrentStudent::with(['student', 'class', 'section'])->get();
    }

    public function store(StoreCurrentStudentRequest $request)
    {
        return CurrentStudent::create($request->validated());
    }

    public function show($id)
    {
        return CurrentStudent::with(['student', 'class', 'section'])->findOrFail($id);
    }

    public function update(UpdateCurrentStudentRequest $request, $id)
    {
        $currentStudent = CurrentStudent::findOrFail($id);
        $currentStudent->update($request->validated());
        return $currentStudent;
    }

    public function destroy($id)
    {
        return CurrentStudent::destroy($id);
    }
}
