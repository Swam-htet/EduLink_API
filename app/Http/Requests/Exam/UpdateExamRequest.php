<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateExamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        if ($this->route('id')) {
            $this->merge(['id' => $this->route('id')]);
        }
    }

    public function rules(): array
    {
        return [
            'id' => 'required|integer|exists:tenant.exams,id',
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'total_marks' => 'sometimes|integer|min:1',
            'pass_marks' => 'sometimes|integer|min:1|lte:total_marks',
            'duration' => 'sometimes|integer|min:1',
            'start_date' => 'sometimes|date|after:now',
            'end_date' => 'sometimes|date|after:start_date',
            'status' => ['sometimes', 'string', Rule::in(['draft', 'published', 'ongoing', 'completed', 'cancelled'])],
            'sections' => 'sometimes|array|min:1',
            'sections.*.section_number' => 'required|integer|min:1',
            'sections.*.section_title' => 'required|string|max:255',
            'sections.*.section_description' => 'nullable|string',
        ];
    }
}
