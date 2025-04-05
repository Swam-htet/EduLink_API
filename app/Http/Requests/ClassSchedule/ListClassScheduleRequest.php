<?php

namespace App\Http\Requests\ClassSchedule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ListClassScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        if ($this->route('class_id')) {
            $this->merge([
                'class_id' => $this->route('class_id')
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'class_id' => 'sometimes|integer|exists:tenant.classes,id',
            'status' => ['sometimes', 'string', Rule::in(['active', 'completed', 'cancelled'])],
            'date' => 'sometimes|date_format:Y-m-d',
            'date_range' => 'sometimes|array',
            'date_range.start' => 'required_with:date_range|date',
            'date_range.end' => 'required_with:date_range|date|after_or_equal:date_range.start',
            'sort_by' => ['sometimes', 'string', Rule::in(['date', 'start_time', 'end_time', 'status'])],
            'sort_order' => ['sometimes', 'string', Rule::in(['asc', 'desc'])],
            'per_page' => 'sometimes|integer|min:1|max:100',
            'current_page' => 'sometimes|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'class_id.exists' => 'Class not found.',
            'status.in' => 'Invalid schedule status.',
            'date.date_format' => 'Date must be in Y-m-d format.',
            'date_range.start.date' => 'Start date must be a valid date.',
            'date_range.end.date' => 'End date must be a valid date.',
            'date_range.end.after_or_equal' => 'End date must be after or equal to start date.',
            'sort_by.in' => 'Invalid sort by.',
            'sort_order.in' => 'Invalid sort order.',
        ];
    }

    public function filters(): array
    {
        return array_merge(
            $this->defaults(),
            $this->validated()
        );
    }

    public function defaults(): array
    {
        return [
            'per_page' => 15,
            'current_page' => 1,
        ];
    }
}
