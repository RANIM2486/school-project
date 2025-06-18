<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClassRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
           'level' => 'sometimes|string|max:255',
            'name' => 'sometimes|string|max:255',
            'student_count' => 'sometimes|integer|min:0',
            'fees' => 'sometimes|numeric|min:0',
        ];
    }
}

/*'level' => 'sometimes|string|max:255',
            'name' => 'sometimes|string|max:255',
            'student_count' => 'sometimes|integer|min:0',
            'fees' => 'sometimes|numeric|min:0',*/
