<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CourseResource;
use App\Http\Resources\SubjectResource;
use App\Http\Resources\StaffResource;


class ClassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'description' => $this->description,
            'start_date' => $this->start_date->format('Y-m-d'),
            'end_date' => $this->end_date->format('Y-m-d'),
            'capacity' => $this->capacity,
            'status' => $this->status,
            'course' => new CourseResource($this->whenLoaded('course')),
            'subject' => new SubjectResource($this->whenLoaded('subject')),
            'teacher' => new StaffResource($this->whenLoaded('teacher')),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
