<?php

namespace App\Http\Requests\Class;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->merge([
            'id' => $this->route('id')
        ]);
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer', Rule::exists('tenant.classes', 'id')->whereNull('deleted_at')],
            'course_id' => ['sometimes', 'required', 'integer', Rule::exists('tenant.courses', 'id')->whereNull('deleted_at')],
            'teacher_id' => ['sometimes', 'required', 'integer', Rule::exists('tenant.staff', 'id')->whereNull('deleted_at')],
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after:start_date',
            'capacity' => 'sometimes|required|integer|min:1',
            'status' => 'sometimes|required|string|in:ongoing,completed,cancelled'
        ];
    }
}
