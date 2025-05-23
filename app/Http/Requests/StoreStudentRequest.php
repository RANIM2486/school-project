<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:ذكر,أنثى',
            'birth_date' => 'required|date',
            'national_id' => 'required|digits:11|unique:students,national_id',
            'address' => 'nullable|string',
            'entry_date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'parent_id' => 'required|exists:users,id',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
        ];
    }
 }
