<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSectionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'class_id' => 'required|exists:classes,id',
            'guide_id' => 'nullable|exists:users,id',
        ];
    }
}


