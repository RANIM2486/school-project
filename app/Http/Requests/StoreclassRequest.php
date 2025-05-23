<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'grade_level' => 'required|string|max:255',         // المرحلة الدراسية
            'class_name' => 'required|string|max:255',          // اسم الصف
            'student_count' => 'required|integer|min:0',        // عدد الطلاب
            'fee' => 'required|numeric|min:0',                  // القسط
        ];
    }
}
