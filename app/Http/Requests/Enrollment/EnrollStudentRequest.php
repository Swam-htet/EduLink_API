<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Foundation\Http\FormRequest;

class EnrollStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_ids' => 'required|array',
            'student_ids.*' => 'required|integer|exists:tenant.students,id',
            'class_id' => 'required|integer|exists:tenant.classes,id',
            'notes' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'student_ids.exists' => 'Student not found.',
            'student_ids.array' => 'Student ids must be an array.',
            'class_id.exists' => 'Class not found.'
        ];
    }
}
