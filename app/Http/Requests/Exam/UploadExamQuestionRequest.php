<?php

namespace App\Http\Requests\Exam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadExamQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    // prepare the data for the request
    protected function prepareForValidation()
    {
        $this->merge([
            'exam_id' => $this->route('exam_id'),
        ]);
    }

    public function rules(): array
    {
        return [
            'exam_id' => ['required', 'integer', 'exists:tenant.exams,id'],

            'exam_questions' => ['required', 'array', 'min:1'],

            'exam_questions.*.section_id' => ['required', 'integer', 'exists:tenant.exam_sections,id'],

            // question
            'exam_questions.*.question' => ['required', 'string', 'max:1000'],

            // question type
            'exam_questions.*.type' => ['required', Rule::in([
                'multiple_choice',
                'true_false',
                'fill_in_blank',
                'short_answer',
                'long_answer',
                'matching',
                'ordering',
                'essay'
            ])],

            // marks
            'exam_questions.*.marks' => ['required', 'integer', 'min:1'],

            // explanation
            'exam_questions.*.explanation' => ['nullable', 'string'],

            // answer guidelines
            'exam_questions.*.answer_guidelines' => ['nullable', 'string'],

            // requires manual grading
            'exam_questions.*.requires_manual_grading' => ['boolean'],

            // difficulty level
            'exam_questions.*.difficulty_level' => ['required', 'integer', 'min:1', 'max:5'],

            // time limit
            'exam_questions.*.time_limit' => ['nullable', 'integer', 'min:1'],

            // Validation per type of question
            'exam_questions.*.options' => [
                'required_if:exam_questions.*.type,multiple_choice,true_false,ordering',
                'array',
            ],
            'exam_questions.*.options.*.id' => [
                'required_with:exam_questions.*.options',
                'string'
            ],
            'exam_questions.*.options.*.text' => [
                'required_with:exam_questions.*.options',
                'string'
            ],

            // Multiple Choice & True/False
            'exam_questions.*.correct_answer' => [
                'required_if:exam_questions.*.type,multiple_choice,true_false',
                'string',
            ],

            // Fill in the Blanks
            'exam_questions.*.blank_answers' => [
                'required_if:exam_questions.*.type,fill_in_blank',
                'array',
            ],
            'exam_questions.*.blank_answers.*.id' => [
                'required_with:exam_questions.*.blank_answers',
                'integer'
            ],
            'exam_questions.*.blank_answers.*.acceptable_answers' => [
                'required_with:exam_questions.*.blank_answers',
                'array'
            ],
            'exam_questions.*.blank_answers.*.acceptable_answers.*' => [
                'string'
            ],
            'exam_questions.*.blank_answers.*.case_sensitive' => [
                'boolean'
            ],

            // Matching Questions
            'exam_questions.*.matching_pairs' => [
                'required_if:exam_questions.*.type,matching',
                'array',
            ],
            'exam_questions.*.matching_pairs.questions' => [
                'required_with:exam_questions.*.matching_pairs',
                'array'
            ],
            'exam_questions.*.matching_pairs.questions.*.id' => [
                'required_with:exam_questions.*.matching_pairs.questions',
                'string'
            ],
            'exam_questions.*.matching_pairs.questions.*.text' => [
                'required_with:exam_questions.*.matching_pairs.questions',
                'string'
            ],
            'exam_questions.*.matching_pairs.answers' => [
                'required_with:exam_questions.*.matching_pairs',
                'array'
            ],
            'exam_questions.*.matching_pairs.answers.*.id' => [
                'required_with:exam_questions.*.matching_pairs.answers',
                'string'
            ],
            'exam_questions.*.matching_pairs.answers.*.text' => [
                'required_with:exam_questions.*.matching_pairs.answers',
                'string'
            ],
            'exam_questions.*.matching_pairs.correct_pairs' => [
                'required_with:exam_questions.*.matching_pairs',
                'array'
            ],

            // Ordering Questions
            'exam_questions.*.correct_order' => [
                'required_if:exam_questions.*.type,ordering',
                'array',
            ],

            // Essay & Long Answer Questions
            'exam_questions.*.answer_guidelines' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'exam_questions.*.question.required' => 'The question field is required.',
            'exam_questions.*.type.required' => 'The question type is required.',
            'exam_questions.*.type.in' => 'The question type must be a valid type.',
            'exam_questions.*.marks.required' => 'Marks are required for each question.',
            'exam_questions.*.difficulty_level.required' => 'Difficulty level is required.',
            'exam_questions.*.difficulty_level.min' => 'Difficulty level must be between 1 and 5.',
            'exam_questions.*.difficulty_level.max' => 'Difficulty level must be between 1 and 5.',
            'exam_questions.*.options.required_if' => 'Options are required for :value questions.',
            'exam_questions.*.correct_answer.required_if' => 'Correct answer is required for :value questions.',
            'exam_questions.*.blank_answers.required_if' => 'Blank answers are required for fill in blank questions.',
            'exam_questions.*.matching_pairs.required_if' => 'Matching pairs are required for matching questions.',
            'exam_questions.*.correct_order.required_if' => 'Correct order is required for ordering questions.',
        ];
    }
}
