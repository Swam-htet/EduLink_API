<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ManualEnrollmentEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    public function prepareForValidation(): void
    {
        // Convert single ID to array for consistent handling
        if (!is_array($this->enrollment_ids) && $this->enrollment_ids) {
            $this->merge([
                'enrollment_ids' => [$this->enrollment_ids]
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'enrollment_ids' => 'required|array|min:1',
            'enrollment_ids.*' => 'required|integer|exists:tenant.student_class_enrollments,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'enrollment_ids.required' => 'Please select at least one enrollment to send email.',
            'enrollment_ids.array' => 'The enrollment selection must be an array.',
            'enrollment_ids.*.exists' => 'One or more selected enrollments do not exist.',
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @return array<string, mixed>
     */
    public function validatedData(): array
    {
        return [
            'enrollment_ids' => $this->enrollment_ids,
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'enrollment_ids' => 'enrollments',
            'enrollment_ids.*' => 'enrollment',
        ];
    }
}
