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
                'start_date' => $this->start_date?->format('Y-m-d H:i:s'),
                'end_date' => $this->end_date?->format('Y-m-d H:i:s'),
            ],
            'sections' => $this->whenLoaded('sections', function () {
                return $this->sections->map(function ($section) {
                    return [
                        'id' => $section->id,
                        'section_number' => $section->section_number,
                        'section_title' => $section->section_title,
                        'total_questions' => $section->total_questions,
                        'total_marks' => $section->total_marks,
                    ];
                });
            }),
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
