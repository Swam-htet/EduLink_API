<?php

namespace App\Http\Requests\Class;

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
            'class_id' => 'required|integer|exists:tenant.classes,id',
            'staff_id' => 'required|integer|exists:tenant.staff,id',
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required|date_format:H:i', // example start time - 10:00
            'end_time' => 'required|date_format:H:i|after:start_time', // example end time - 11:00
            'late_mins' => 'required|integer|min:0', // example late mins - 10
            'notes' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'day_of_week.between' => 'Day must be between Sunday (0) and Saturday (6).',
            'end_time.after' => 'End time must be after start time.',
        ];
    }
}
