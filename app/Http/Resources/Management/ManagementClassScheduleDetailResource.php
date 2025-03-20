<?php

namespace App\Http\Resources\Management;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManagementClassScheduleDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'class' => $this->whenLoaded('class', function () {
                return [
                    'id' => $this->class->id,
                    'name' => $this->class->name,
                    'code' => $this->class->code,
                ];
            }),
            'tutor' => $this->whenLoaded('staff', function () {
                return [
                    'id' => $this->staff->id,
                    'first_name' => $this->staff->first_name,
                    'last_name' => $this->staff->last_name,
                    'email' => $this->staff->email,
                    'phone' => $this->staff->phone,
                ];
            }),
            'schedule_details' => [
                // if start_time is in the past, then the schedule is pending, completed, or cancelled
                'schedule_status' => $this->start_time->isPast() ? ($this->status === 'completed' ? 'completed' : ($this->status === 'cancelled' ? 'cancelled' : 'pending')) : 'ongoing',
                'start_date' => $this->date && $this->start_time
                    ? $this->date->format('Y-m-d') . ' ' . $this->start_time->format('H:i:s')
                    : null,
                'end_date' => $this->date && $this->end_time
                    ? $this->date->format('Y-m-d') . ' ' . $this->end_time->format('H:i:s')
                    : null,
                'late_mins' => $this->late_mins,
            ],
            'status_info' => [
                'status' => $this->status,
                'cancellation_reason' => $this->when($this->status === 'cancelled', $this->cancellation_reason),
            ],
            'meta' => [
                'total_students' => $this->whenLoaded('attendances', function () {
                    return $this->attendances->count();
                }),
                'present_students' => $this->whenLoaded('attendances', function () {
                    return $this->attendances->where('status', 'present')->count();
                }),
                'absent_students' => $this->whenLoaded('attendances', function () {
                    return $this->attendances->where('status', 'absent')->count();
                }),
                'late_students' => $this->whenLoaded('attendances', function () {
                    return $this->attendances->where('status', 'late')->count();
                }),
            ],
            'timestamps' => [
                'created_at' => $this->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            ],
        ];
    }
}
