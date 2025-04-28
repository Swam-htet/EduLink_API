<?php

namespace App\Http\Resources\Management;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManagementExamResultDetailResource extends JsonResource
{
    public $answers;
    public function __construct($resource, $answers)
    {
        $this->answers = $answers;
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student' => [
                'id' => $this->student->student_id,
                'name' => $this->student->first_name . ' ' . $this->student->last_name,
                'email' => $this->student->email,
            ],
            'total_marks_obtained' => $this->total_marks_obtained,
            'total_questions' => $this->total_questions,
            'correct_answers' => $this->correct_answers,
            'wrong_answers' => $this->wrong_answers,
            'skipped_questions' => $this->total_questions - ($this->correct_answers + $this->wrong_answers),
            'condition' => $this->condition,
            'status' => $this->status,
            'submitted_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'answers' => $this->answers ? $this->formatAnswers($this->answers) : null
        ];
    }

    // format answers based on question type
    public function formatAnswers($answers)
    {
        return $answers->map(function ($answer) {
            $formattedAnswer = [
                'id' => $answer->id,
                'question' => $this->formatQuestion($answer->question),
                'is_correct' => $answer->is_correct,
                'marks_obtained' => $answer->marks_obtained,
                'grading_comments' => $answer->grading_comments,
                'answered_at' => $answer->answered_at?->format('Y-m-d H:i:s'),
            ];

            // Format answer based on question type
            switch ($answer->question->type) {
                case 'multiple_choice':
                    $formattedAnswer['selected_choice'] = $answer->selected_choice;
                    break;
                case 'true_false':
                    $formattedAnswer['selected_choice'] = $answer->selected_choice;
                    break;
                case 'fill_in_blank':
                    $formattedAnswer['fill_in_blank_answers'] = $answer->fill_in_blank_answers;
                    break;
                case 'short_answer':
                case 'long_answer':
                case 'essay':
                    $formattedAnswer['written_answer'] = $answer->written_answer;
                    break;
                case 'matching':
                    $formattedAnswer['matching_answers'] = $answer->matching_answers;
                    break;
                case 'ordering':
                    $formattedAnswer['ordering_answer'] = $answer->ordering_answer;
                    break;
            }

            return $formattedAnswer;
        });
    }

    public function formatQuestion($question)
    {
        $baseQuestion = [
                'id' => $question->id,
                'question' => $question->question,
                'type' => $question->type,
                'marks' => $question->marks,
                'explanation' => $question->explanation,
                'answer_guidelines' => $question->answer_guidelines,
                'requires_manual_grading' => $question->requires_manual_grading,
                'difficulty_level' => $question->difficulty_level,
                'time_limit' => $question->time_limit,
            ];

            // Add type-specific data
            switch ($question->type) {
                case 'multiple_choice':
                case 'true_false':
                    return array_merge($baseQuestion, [
                        'options' => $question->options,
                    ]);

                case 'matching':
                    return array_merge($baseQuestion, [
                        'matching_pairs' => [
                            'questions' => $question->matching_pairs['questions'] ?? [],
                            'answers' => $question->matching_pairs['answers'] ?? [],
                        ],
                    ]);

                case 'ordering':
                    return array_merge($baseQuestion, [
                        'options' => $question->options,
                    ]);

                default:
                    return $baseQuestion;
        }
    }
}
