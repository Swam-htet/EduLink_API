<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListManagementAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'sometimes|integer|exists:tenant.students,id',
            'class_id' => 'sometimes|integer|exists:tenant.classes,id',
            'class_schedule_id' => 'sometimes|integer|exists:tenant.class_schedules,id',
            'status' => ['sometimes', 'string', Rule::in(['present', 'absent', 'late', 'excused'])],
            'date_range' => 'sometimes|array',
            'date_range.start' => 'required_with:date_range|date',
            'date_range.end' => 'required_with:date_range|date|after_or_equal:date_range.start',
            'per_page' => 'sometimes|integer|min:1|max:100',
        ];
    }

    public function filters(): array
    {
        return array_filter($this->validated(), function ($value) {
            return $value !== null;
        });
    }
}
