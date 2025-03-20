<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'student_id' => $this->route('student_id')
        ]);
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required|integer|exists:tenant.students,id',
            'class_id' => 'sometimes|integer|exists:tenant.classes,id',
            'subject_id' => 'sometimes|integer|exists:tenant.subjects,id',
            'class_schedule_id' => 'sometimes|integer|exists:tenant.class_schedules,id',
            'status' => ['sometimes', 'string', Rule::in(['present', 'absent', 'late', 'excused'])],
            'date_range' => 'sometimes|array',
            'date_range.start' => 'required_with:date_range|date',
            'date_range.end' => 'required_with:date_range|date|after_or_equal:date_range.start',
            'per_page' => 'sometimes|integer|min:1|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.exists' => 'Student not found.',
            'class_id.exists' => 'Class not found.',
            'subject_id.exists' => 'Subject not found.',
            'class_schedule_id.exists' => 'Class schedule not found.',
            'status.in' => 'Invalid attendance status.',
        ];
    }

    public function filters(): array
    {
        return array_filter($this->validated(), function ($value) {
            return $value !== null;
        });
    }
}
