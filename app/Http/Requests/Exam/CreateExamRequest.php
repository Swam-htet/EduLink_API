<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateExamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'class_id' => 'required|integer|exists:tenant.classes,id',
            'subject_id' => 'required|integer|exists:tenant.subjects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'total_marks' => 'required|integer|min:1',
            'pass_marks' => 'required|integer|min:1|lte:total_marks',
            'duration' => 'required|integer|min:1',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'sections' => 'required|array|min:1',
            'sections.*.section_number' => 'required|integer|min:1',
            'sections.*.section_title' => 'required|string|max:255',
            'sections.*.section_description' => 'nullable|string',
        ];
    }
}
