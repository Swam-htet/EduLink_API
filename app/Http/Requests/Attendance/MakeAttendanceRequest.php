<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class MakeAttendanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'class_schedule_id' => $this->route('class_schedule_id')
        ]);
    }

    public function rules(): array
    {
        return [
            'class_schedule_id' => 'required|integer|exists:tenant.class_schedules,id',
            'remarks' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'class_schedule_id.exists' => 'Class schedule not found.',
        ];
    }
}
