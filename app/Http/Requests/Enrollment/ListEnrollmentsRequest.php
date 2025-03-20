<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListEnrollmentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Basic Filters
            'student_id' => 'sometimes|integer|exists:tenant.students,id',
            'class_id' => 'sometimes|integer|exists:tenant.classes,id',
            'status' => ['sometimes', 'string', Rule::in(['enrolled', 'completed', 'failed'])],

            // Date Range Filter
            'enrolled_at' => 'sometimes|array',
            'enrolled_at.start' => 'required_with:enrolled_at|date',
            'enrolled_at.end' => 'required_with:enrolled_at|date|after_or_equal:enrolled_at.start',

            // Pagination and Sorting
            'per_page' => 'sometimes|integer|min:1|max:100',
            'sort_by' => ['sometimes', 'string', Rule::in([
                'student_id',
                'class_id',
                'enrolled_at',
                'status',
                'created_at',
                'updated_at'
            ])],
            'sort_direction' => ['sometimes', 'string', Rule::in(['asc', 'desc'])],
        ];
    }

    public function defaults(): array
    {
        return [
            'per_page' => 15,
            'sort_by' => 'created_at',
            'sort_direction' => 'desc'
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