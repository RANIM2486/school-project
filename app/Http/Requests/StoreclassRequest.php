<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
           'level' => 'required|string|max:255',         // المرحلة الدراسية
            'name' => 'required|string|max:255',          // اسم الصف
            'students_count' => 'required|integer|min:0',        // عدد الطلاب
            'fees' => 'required|numeric|min:0',                  // القسط*
        ];
    }
}

/*  'level' => 'required|string|max:255',         // المرحلة الدراسية
            'name' => 'required|string|max:255',          // اسم الصف
            'student_count' => 'required|integer|min:0',        // عدد الطلاب
            'fees' => 'required|numeric|min:0',                  // القسط*/
