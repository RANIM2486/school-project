<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSectionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'class_id' => 'sometimes|exists:classes,id',
            'guide_id' => 'nullable|exists:users,id',
            'teacher_id' => 'nullable|exists:users,id',
        ];
    }
}
