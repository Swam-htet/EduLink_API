<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubmitExamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {
        if ($this->route('id')) {
            $this->merge(['exam_id' => $this->route('id')]);
        }
    }

    public function rules(): array
    {
        return [
            'exam_id' => ['required', 'integer', 'exists:tenant.exams,id'],
            'answers' => ['required', 'array'],
            'answers.*.question_id' => ['required', 'integer', 'exists:tenant.exam_questions,id'],
            'answers.*.section_id' => ['required', 'integer'],
            'answers.*.type' => ['required', 'string', Rule::in([
                'multiple_choice',
                'true_false',
                'fill_in_blank',
                'short_answer',
                'long_answer',
                'matching',
                'ordering',
                'essay'
            ])],
            'answers.*.answer' => ['nullable'],
            'answers.*.answer.multiple_choice' => ['nullable', 'string'],
            'answers.*.answer.true_false' => ['nullable', 'string', Rule::in(['true', 'false'])],
            'answers.*.answer.fill_in_blank' => ['nullable', 'array'],
            'answers.*.answer.fill_in_blank.*' => ['nullable', 'string'],
            'answers.*.answer.short_answer' => ['nullable', 'string'],
            'answers.*.answer.long_answer' => ['nullable', 'string'],
            'answers.*.answer.matching' => ['nullable', 'array'],
            'answers.*.answer.matching.*.question' => ['nullable', 'string'],
            'answers.*.answer.matching.*.answer' => ['nullable', 'string'],
            'answers.*.answer.ordering' => ['nullable', 'array'],
            'answers.*.answer.ordering.*' => ['nullable', 'string'],
            'answers.*.answer.essay' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'exam_id.required' => 'Exam ID is required',
            'exam_id.exists' => 'The selected exam does not exist',
            'answers.required' => 'Answers are required',
            'answers.array' => 'Answers must be an array',
            'answers.*.question_id.required' => 'Question ID is required for each answer',
            'answers.*.question_id.exists' => 'The selected question does not exist',
            'answers.*.type.required' => 'Question type is required',
            'answers.*.type.in' => 'Invalid question type',
            'answers.*.answer.required' => 'Answer is required',
            'answers.*.answer.multiple_choice.required_if' => 'Multiple choice answer is required',
            'answers.*.answer.true_false.required_if' => 'True/False answer is required',
            'answers.*.answer.fill_in_blank.required_if' => 'Fill in blank answers are required',
            'answers.*.answer.short_answer.required_if' => 'Short answer is required',
            'answers.*.answer.long_answer.required_if' => 'Long answer is required',
            'answers.*.answer.matching.required_if' => 'Matching answers are required',
            'answers.*.answer.ordering.required_if' => 'Ordering answers are required',
            'answers.*.answer.essay.required_if' => 'Essay answer is required',
            'answers.*.answer.session_id.required' => 'Session ID is required',
        ];
    }
}