<?php

namespace App\Http\Requests\Subject;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListSubjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'course_id' => 'sometimes|integer|exists:tenant.courses,id',
            'title' => 'sometimes|string|max:255',
            'code' => 'sometimes|string|max:50',
            'credits' => 'sometimes|integer',
            'sort_by' => ['sometimes', 'string', Rule::in([
                'title',
                'code',
                'credits',
                'course_id',
                'created_at',
                'updated_at'
            ])],
            'sort_direction' => ['sometimes', 'string', Rule::in(['asc', 'desc'])],
        ];
    }

    /**
     * Get the default values for filters
     *
     * @return array
     */
    public function defaults(): array
    {
        return [
            'sort_by' => 'created_at',
            'sort_direction' => 'desc'
        ];
    }

    /**
     * Get the filters with default values
     *
     * @return array
     */
    public function filters(): array
    {
        $defaults = $this->defaults();
        $filters = $this->validated();

        return array_merge($defaults, $filters);
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'course_id.exists' => 'The selected course does not exist.',
            'status.in' => 'The status must be either active or inactive.',
            'credits.integer' => 'Credits must be a whole number.',
        ];
    }
}
