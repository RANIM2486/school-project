<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGradeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'sometimes|exists:students,id',
            'subject_id' => 'sometimes|exists:subjects,id',
            'exam1' => 'nullable|integer|min:0|max:100',
            'exam2' => 'nullable|integer|min:0|max:100',
            'exam3' => 'nullable|integer|min:0|max:100',
            'quiz' => 'nullable|integer|min:0|max:100',
            'final_exam' => 'nullable|integer|min:0|max:100',
            'date' => 'nullable|date',
        ];
    }
}
