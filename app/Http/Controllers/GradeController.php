<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\SubjectResource;
use App\Models\Subject;
use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use Illuminate\Support\Facades\Cache;



class GradeController extends Controller
{



    public function index()
    {
        return Cache::remember('subjects', 3600, function () {
            return SubjectResource::collection(
                Subject::with(['teacher', 'classes'])->get()
            );
        });
    }

    public function store(StoreSubjectRequest $request)
    {
        $subject = Subject::create($request->validated());

        Cache::forget('subjects');

        return new SubjectResource($subject->load('teacher'));
    }

    public function show(Subject $subject)
    {
        return new SubjectResource($subject->load(['teacher', 'classes', 'grades']));
    }

    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $subject->update($request->validated());

        Cache::forget('subjects');

        return new SubjectResource($subject);
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();

        Cache::forget('subjects');

        return response()->json([
            'message' => 'تم حذف المادة الدراسية'
        ]);
    }

}
