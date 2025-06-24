<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'sometimes|string|max:255',
            'father_name' => 'sometimes|string|max:255',
            'mother_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'gender' => 'sometimes|in:ذكر,أنثى',
            'birth_date' => 'sometimes|date',
            'address' => 'nullable|string|max:255',
            'entry_date' => 'sometimes|date',
            'class_id' => 'sometimes|exists:classes,id',
            'section_id' => 'sometimes|exists:sections,id',
            'parent_id' => 'sometimes|exists:users,id',
           // ' user_id' => 'required|exists:users,id',
        ];
    }
}
