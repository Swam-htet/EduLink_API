<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;

class ManualGradingExamResultRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'answer_id' => ['required', 'integer', 'exists:tenant.student_exam_responses,id'],
            'marks' => ['required', 'numeric', 'min:1'],
            'comments' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'answer_id.required' => 'Answer ID is required',
            'answer_id.exists' => 'The selected answer does not exist',
            'marks.required' => 'Marks are required',
            'marks.numeric' => 'Marks must be a number',
            'marks.min' => 'Marks cannot be negative',
            'comments.string' => 'Comments must be a string',
            'comments.max' => 'Comments cannot exceed 1000 characters',
        ];
    }
}