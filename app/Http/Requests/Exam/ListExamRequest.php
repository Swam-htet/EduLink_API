<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListExamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->route('class_id')) {
            $this->merge(['class_id' => $this->route('class_id')]);
        }
    }

    public function rules(): array
    {
        return [
            'class_id' => 'sometimes|integer|exists:tenant.classes,id',
            'subject_id' => 'sometimes|integer|exists:tenant.subjects,id',
            'title' => 'sometimes|string',
            'status' => ['sometimes', Rule::in(['draft', 'published', 'ongoing', 'completed', 'cancelled'])],
            'date_range' => 'sometimes|array',
            'date_range.start' => 'required_with:date_range|date',
            'date_range.end' => 'required_with:date_range|date|after_or_equal:date_range.start',
            'per_page' => 'sometimes|integer|min:1|max:100',
            'sort_by' => ['sometimes', Rule::in(['title', 'start_date', 'created_at'])],
            'sort_direction' => ['sometimes', Rule::in(['asc', 'desc'])],
        ];
    }

    public function filters(): array
    {
        return array_merge([
            'per_page' => $this->per_page ?? 15,
            'sort_by' => $this->sort_by ?? 'created_at',
            'sort_direction' => $this->sort_direction ?? 'desc',
        ], array_filter($this->only([
            'class_id',
            'subject_id',
            'title',
            'status',
            'date_range',
        ])));
    }
}
