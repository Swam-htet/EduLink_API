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
            'student_id' => 'required|integer|exists:tenant.students,id',
            'class_id' => 'required|integer|exists:tenant.classes,id',
            'notes' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.exists' => 'Student not found.',
            'class_id.exists' => 'Class not found.'
        ];
    }
}
