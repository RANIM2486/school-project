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
            'level' => 'required|string|max:255',         // المرحلة الدراسية
            'name' => 'required|string|max:255',          // اسم الصف
            'student_count' => 'required|integer|min:0',        // عدد الطلاب
            'fees' => 'required|numeric|min:0',                  // القسط
        ];
    }
}
