<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExamResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'class' => $this->whenLoaded('class', function () {
                return [
                    'id' => $this->class->id,
                    'name' => $this->class->name,
                    'code' => $this->class->code,
                ];
            }),
            'subject' => $this->whenLoaded('subject', function () {
                return [
                    'id' => $this->subject->id,
                    'title' => $this->subject->title,
                    'code' => $this->subject->code,
                ];
            }),
            'exam_details' => [
                'total_marks' => $this->total_marks,
                'pass_marks' => $this->pass_marks,
                'duration' => $this->duration,
            ],
            'schedule' => [
                'exam_date' => $this->exam_date?->format('Y-m-d'),
                'start_time' => $this->start_time?->format('H:i'),
                'end_time' => $this->end_time?->format('H:i'),
            ],
            'sections' => $this->whenLoaded('sections', function () {
                return $this->sections->map(function ($section) {
                    return [
                        'id' => $section->id,
                        'section_number' => $section->section_number,
                        'section_title' => $section->section_title,
                        'total_questions' => $section->total_questions,
                        'total_marks' => $section->total_marks,
                        'questions' => $this->formatQuestions($section->questions),
                    ];
                });
            }),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }

      protected function formatQuestions($questions)
    {
        if (!$questions) return [];

        return $questions->map(function ($question) {
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
        });
    }
}
