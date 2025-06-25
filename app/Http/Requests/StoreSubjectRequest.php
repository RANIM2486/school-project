<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'min_grade' => 'required|integer|min:0|max:100',
            'max_grade' => 'required|integer|min:1|max:100',
            'exam1' => 'required|integer|min:0|max:100',
            'exam2' => 'required|integer|min:0|max:100',
            'exam3' => 'required|integer|min:0|max:100',
            'final_exam' => 'required|integer|min:0|max:100',
            'teacher_id' => 'required|exists:users,id',
        ];
    }
}

 /* */
