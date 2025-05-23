<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'grade_level' => 'sometimes|string|max:255',
            'class_name' => 'sometimes|string|max:255',
            'student_count' => 'sometimes|integer|min:0',
            'fee' => 'sometimes|numeric|min:0',
        ];
    }
}
