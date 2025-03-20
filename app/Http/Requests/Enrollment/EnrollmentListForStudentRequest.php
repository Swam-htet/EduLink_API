<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EnrollmentListForStudentRequest extends FormRequest
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
        $this->merge([
            'student_id' => $this->route('student_id')
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'student_id' => 'required|integer|exists:tenant.students,id',
            'class_id' => 'sometimes|integer|exists:tenant.classes,id',
            'status' => ['sometimes', 'string', Rule::in(['enrolled', 'completed', 'failed'])],
            'enrolled_date' => 'sometimes|array',
            'enrolled_date.start' => 'required_with:enrolled_date|date',
            'enrolled_date.end' => 'required_with:enrolled_date|date|after_or_equal:enrolled_date.start',
            'sort_by' => ['sometimes', 'string', Rule::in(['enrolled_at', 'status'])],
            'sort_direction' => ['sometimes', 'string', Rule::in(['asc', 'desc'])],
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
            'student_id.exists' => 'Student not found.',
            'class_id.exists' => 'Class not found.',
            'status.in' => 'Invalid enrollment status.',
            'enrolled_date.start.date' => 'Invalid start date format.',
            'enrolled_date.end.date' => 'Invalid end date format.',
            'enrolled_date.end.after_or_equal' => 'End date must be after or equal to start date.',
            'sort_by.in' => 'Invalid sort by field.',
            'sort_direction.in' => 'Invalid sort direction.',
        ];
    }

    /**
     * Get the validated data from the request.
     *
     * @return array<string, mixed>
     */
    public function filters(): array
    {
        return array_filter($this->validated(), function ($value) {
            return $value !== null;
        });
    }
}
