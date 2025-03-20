<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'student' => new StudentResource($this->student),
            'class_schedule' => new ClassScheduleResource($this->classSchedule),
            'attendance_details' => [
                'status' => $this->status,
                'time_in' => $this->time_in?->format('H:i:s'),
                'time_out' => $this->time_out?->format('H:i:s'),
                'remarks' => $this->remarks,
            ],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
