<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListStaffRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Basic Filters
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email',
            'phone' => 'sometimes|string',
            'nrc' => 'sometimes|string',

            // Status and Role Filters
            'status' => ['sometimes', 'string', Rule::in(['active', 'inactive'])],
            'role' => ['sometimes', 'string', Rule::in(['teacher', 'admin', 'staff'])],
            'gender' => ['sometimes', 'string', Rule::in(['male', 'female', 'other'])],

            // Date Range Filters
            'date_of_birth' => 'sometimes|array', // eg : date_of_birth[start] = 2024-01-01, date_of_birth[end] = 2024-01-31
            'date_of_birth.start' => 'required_with:date_of_birth|date',
            'date_of_birth.end' => 'required_with:date_of_birth|date|after_or_equal:date_of_birth.start',

            'joined_date' => 'sometimes|array', // eg : joined_date[start] = 2024-01-01, joined_date[end] = 2024-01-31
            'joined_date.start' => 'required_with:joined_date|date',
            'joined_date.end' => 'required_with:joined_date|date|after_or_equal:joined_date.start',

            // Pagination and Sorting
            'per_page' => 'sometimes|integer|min:1|max:100',
            'sort_by' => ['sometimes', 'string', Rule::in([
                'name',
                'email',
                'role',
                'joined_date',
                'status',
                'created_at',
                'updated_at'
            ])],
            'sort_direction' => ['sometimes', 'string', Rule::in(['asc', 'desc'])],
        ];
    }

    /**
     * Get the default values for filters
     */
    public function defaults(): array
    {
        return [
            'per_page' => 15,
            'sort_by' => 'created_at',
            'sort_direction' => 'desc'
        ];
    }

    /**
     * Get the filters with default values
     */
    public function filters(): array
    {
        return array_merge(
            $this->defaults(),
            $this->validated()
        );
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'status.in' => 'The status must be either active or inactive.',
            'role.in' => 'The role must be either teacher, admin, or staff.',
            'gender.in' => 'The gender must be either male, female, or other.',
            'date_of_birth.start.required_with' => 'Start date is required when filtering by date of birth range.',
            'date_of_birth.end.required_with' => 'End date is required when filtering by date of birth range.',
            'date_of_birth.end.after_or_equal' => 'End date must be after or equal to start date.',
            'joined_date.start.required_with' => 'Start date is required when filtering by joined date range.',
            'joined_date.end.required_with' => 'End date is required when filtering by joined date range.',
            'joined_date.end.after_or_equal' => 'End date must be after or equal to start date.',
            'email.email' => 'Please enter a valid email address.',
        ];
    }
}
