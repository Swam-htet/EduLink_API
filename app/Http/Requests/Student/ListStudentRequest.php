<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Basic Filters
            'student_id' => 'sometimes|string',
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email',
            'phone' => 'sometimes|string',
            'nrc' => 'sometimes|string',

            // Status and Gender Filters
            'status' => ['sometimes', 'string', Rule::in(['pending', 'active', 'inactive', 'suspended', 'rejected'])],
            'gender' => ['sometimes', 'string', Rule::in(['male', 'female', 'other'])],

            // Date Range Filters
            'date_of_birth' => 'sometimes|array',
            'date_of_birth.start' => 'required_with:date_of_birth|date',
            'date_of_birth.end' => 'required_with:date_of_birth|date|after_or_equal:date_of_birth.start',

            'enrollment_date' => 'sometimes|array',
            'enrollment_date.start' => 'required_with:enrollment_date|date',
            'enrollment_date.end' => 'required_with:enrollment_date|date|after_or_equal:enrollment_date.start',

            // Guardian Filters
            'guardian_name' => 'sometimes|string',
            'guardian_phone' => 'sometimes|string',

            // Pagination and Sorting
            'per_page' => 'sometimes|integer|min:1|max:100',
            'sort_by' => ['sometimes', 'string', Rule::in([
                'student_id',
                'first_name',
                'last_name',
                'email',
                'enrollment_date',
                'status',
                'phone',
                'created_at',
                'updated_at',
                'gender'
            ])],
            'sort_direction' => ['sometimes', 'string', Rule::in(['asc', 'desc'])],
            'current_page' => 'sometimes|integer|min:1',
        ];
    }

    public function defaults(): array
    {
        return [
            'per_page' => 15,
            'sort_by' => 'created_at',
            'sort_direction' => 'desc',
            'current_page' => 1
        ];
    }

    public function filters(): array
    {
        return array_merge(
            $this->defaults(),
            $this->validated()
        );
    }
}
