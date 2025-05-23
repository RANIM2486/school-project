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
            'national_id' => 'sometimes|digits:11|unique:students,national_id,' . $this->route('id'),
            'address' => 'nullable|string',
            'entry_date' => 'sometimes|date',
            'user_id' => 'sometimes|exists:users,id',
            'parent_id' => 'sometimes|exists:users,id',
            'class_id' => 'sometimes|exists:classes,id',
            'section_id' => 'sometimes|exists:sections,id',
        ];
    }
 }
