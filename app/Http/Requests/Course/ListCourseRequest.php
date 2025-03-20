<?php

namespace App\Http\Requests\Course;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'code' => 'sometimes|string|max:50',
            'status' => ['sometimes', 'string', Rule::in(['active', 'inactive'])],
            'sort_by' => ['sometimes', 'string', Rule::in([
                'name', 'code', 'created_at', 'updated_at'
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
}