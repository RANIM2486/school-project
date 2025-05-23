<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGradeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'exam1' => 'nullable|integer|min:0|max:100',
            'exam2' => 'nullable|integer|min:0|max:100',
            'exam3' => 'nullable|integer|min:0|max:100',
            'quiz' => 'nullable|integer|min:0|max:100',
            'final_exam' => 'nullable|integer|min:0|max:100',
            'date' => 'nullable|date',
        ];
    }
}
