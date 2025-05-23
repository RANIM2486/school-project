<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

     public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'min_grade' => 'sometimes|integer|min:0|max:100',
            'max_grade' => 'sometimes|integer|min:1|max:100',
            'exam1' => 'nullable|integer|min:0|max:100',
            'exam2' => 'nullable|integer|min:0|max:100',
            'exam3' => 'nullable|integer|min:0|max:100',
            'final_exam' => 'nullable|integer|min:0|max:100',
            'teacher_id' => 'nullable|exists:users,id',
        ];
    }
 }
