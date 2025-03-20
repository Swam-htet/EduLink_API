<?php

namespace App\Http\Requests\ClassSchedule;

use Illuminate\Foundation\Http\FormRequest;

class CreateClassScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'schedules' => 'required|array',
            'schedules.*.class_id' => 'required|integer|exists:tenant.classes,id',
            'schedules.*.subject_id' => 'required|integer|exists:tenant.subjects,id',
            'schedules.*.staff_id' => 'required|integer|exists:tenant.staff,id',
            'schedules.*.date' => 'required|date',
            'schedules.*.start_time' => 'required|date_format:H:i',
            'schedules.*.end_time' => 'required|date_format:H:i|after:start_time',
            'schedules.*.late_mins' => 'required|integer|min:0',
        ];
    }

    public function messages(): array
    {
        return [
            'schedules.*.end_time.after' => 'End time must be after start time.',
        ];
    }
}
