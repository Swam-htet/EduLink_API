<?php

namespace App\Http\Resources\Management;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManagementClassScheduleResource extends JsonResource
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
            'class' => [
                'id' => $this->class->id,
                'name' => $this->class->name,
                'code' => $this->class->code,
            ],
            'subject' => [
                'id' => $this->subject->id,
                'title' => $this->subject->title,
                'code' => $this->subject->code,
            ],
            'tutor' => [
                'id' => $this->staff->id,
                'first_name' => $this->staff->first_name,
                'last_name' => $this->staff->last_name,
                'email' => $this->staff->email,
                'phone' => $this->staff->phone,
            ],
            'schedule_details' => [
                'schedule_status' => $this->start_time->isPast() ? ($this->status === 'completed' ? 'completed' : ($this->status === 'cancelled' ? 'cancelled' : 'pending')) : 'ongoing',
                'start_date' => $this->date && $this->start_time
                    ? $this->date->format('Y-m-d') . ' ' . $this->start_time->format('H:i:s')
                    : null,
                'end_date' => $this->date && $this->end_time
                    ? $this->date->format('Y-m-d') . ' ' . $this->end_time->format('H:i:s')
                    : null,
                'late_mins' => $this->late_mins,
            ],
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
