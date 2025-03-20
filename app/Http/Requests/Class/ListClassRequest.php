<?php

namespace App\Http\Requests\Class;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListClassRequest extends FormRequest
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
            'code' => 'sometimes|string|max:50',
            'status' => ['sometimes', 'string', Rule::in(['active', 'inactive'])],

            // Relationship Filters
            'course_id' => 'sometimes|integer|exists:tenant.courses,id',
            'subject_id' => 'sometimes|integer|exists:tenant.subjects,id',
            'teacher_id' => 'sometimes|integer|exists:tenant.staff,id',

            // Date Filters
            'date_range' => 'sometimes|array',
            'date_range.start' => 'required_with:date_range|date',
            'date_range.end' => 'required_with:date_range|date|after_or_equal:date_range.start',

            // Capacity Filter
            'capacity' => [
                'sometimes',
                'array',
                Rule::in(['available', 'full']),
            ],

            // Pagination and Sorting
            'per_page' => 'sometimes|integer|min:1|max:100',
            'sort_by' => ['sometimes', 'string', Rule::in([
                'name',
                'code',
                'start_date',
                'end_date',
                'capacity',
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
            'course_id.exists' => 'The selected course does not exist.',
            'subject_id.exists' => 'The selected subject does not exist.',
            'teacher_id.exists' => 'The selected teacher does not exist.',
            'status.in' => 'The status must be either active or inactive.',
            'date_range.start.required_with' => 'Start date is required when filtering by date range.',
            'date_range.end.required_with' => 'End date is required when filtering by date range.',
            'date_range.end.after_or_equal' => 'End date must be after or equal to start date.',
            'capacity.in' => 'Capacity filter must be either available or full.',
        ];
    }
}