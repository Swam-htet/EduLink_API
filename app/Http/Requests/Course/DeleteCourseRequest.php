<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class DeleteCourseRequest extends FormRequest
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
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Course ID is required.',
            'id.integer' => 'Course ID must be an integer.',
            'id.exists' => 'Course not found.'
        ];
    }
}
