<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

     public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:إيجابية,سلبية,تحذير',
            'student_id' => 'required|exists:current_students,id',
            'teacher_id' => 'required|exists:users,id',
        ];
    }
 }
