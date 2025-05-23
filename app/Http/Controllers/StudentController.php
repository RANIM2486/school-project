<?php

namespace App\Http\Controllers;

use App\Http\Resources\StudentResource;
use App\Http\Resources\StudentDetailsResource;
use App\Models\Student;
use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{

    public function index()
    {
        $students = Student::with(['class', 'section', 'grades', 'comments'])
            ->filter(request()->only('search', 'class_id', 'section_id'))
            ->paginate(10);

        return StudentResource::collection($students);
    }

    public function store(StoreStudentRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('students', 'public');
        }

        $student = Student::create($data);

        return new StudentDetailsResource($student->load(['class', 'section']));
    }

    public function show(Student $student)
    {
        return new StudentDetailsResource($student->load([
            'class',
            'section',
            'grades.subject',
            'comments.user'
        ]));
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            if ($student->photo_path) {
                Storage::disk('public')->delete($student->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('students', 'public');
        }

        $student->update($data);

        return new StudentDetailsResource($student);
    }

    public function destroy(Student $student)
    {
        if ($student->photo_path) {
            Storage::disk('public')->delete($student->photo_path);
        }

        $student->delete();

        return response()->json([
            'message' => 'تم حذف الطالب بنجاح'
        ]);
    }
}
