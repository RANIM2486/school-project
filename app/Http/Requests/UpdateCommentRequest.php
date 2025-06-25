<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

     public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255',
            'date' => 'sometimes|date',
            'type' => 'sometimes|in:إيجابية,سلبية,تحذير',
        'current_student_id' => 'required|exists:current_students,id',
            'user_id' => 'sometimes|exists:users,id',
        ];
    }
 }
