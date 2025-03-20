<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEnrollmentRequest extends FormRequest
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
            'id' => 'required|integer|exists:tenant.student_class_enrollments,id',
            'status' => ['required', 'string', Rule::in(['enrolled', 'completed', 'failed'])],
            'remarks' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'id.exists' => 'The enrollment record does not exist.',
            'status.in' => 'The status must be either enrolled, completed, or failed.',
        ];
    }
}
