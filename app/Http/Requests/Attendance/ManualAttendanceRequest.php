<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ManualAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id' => 'required|integer|exists:tenant.students,id',
            'class_schedule_id' => 'required|integer|exists:tenant.class_schedules,id',
            'status' => ['required', 'string', Rule::in(['present', 'absent', 'late', 'excused'])],
            'remarks' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.exists' => 'Student not found.',
            'class_schedule_id.exists' => 'Class schedule not found.',
            'status.in' => 'Invalid attendance status.',
        ];
    }
}
