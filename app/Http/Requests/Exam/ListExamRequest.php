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
            'exam_date' => 'sometimes|date',
            'start_time' => 'sometimes|date_format:H:i',
            'end_time' => 'sometimes|date_format:H:i',
            'per_page' => 'sometimes|integer|min:1|max:100',
            'sort_by' => ['sometimes', Rule::in(['title', 'exam_date', 'created_at'])],
            'sort_direction' => ['sometimes', Rule::in(['asc', 'desc'])],
            'current_page' => 'sometimes|integer|min:1',
        ];
    }

    public function filters(): array
    {
        return array_merge([
            'per_page' => $this->per_page ?? 15,
            'sort_by' => $this->sort_by ?? 'created_at',
            'sort_direction' => $this->sort_direction ?? 'desc',
            'current_page' => $this->current_page ?? 1,
        ], array_filter($this->only([
            'class_id',
            'subject_id',
            'title',
            'status',
            'exam_date',
            'start_time',
            'end_time',
        ])));
    }
}
