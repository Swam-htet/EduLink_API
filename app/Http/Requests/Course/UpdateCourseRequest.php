<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCourseRequest extends FormRequest
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
            'id' => [
                'required',
                'integer',
                Rule::exists('tenant.courses', 'id')->whereNull('deleted_at'),
            ],
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'duration' => 'sometimes|required|integer|min:1',
            'duration_unit' => 'sometimes|required|string|in:hours,days,weeks,months',
            'status' => 'sometimes|required|string|in:active,inactive',
        ];
    }
}
