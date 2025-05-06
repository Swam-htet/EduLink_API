<?php

namespace App\Http\Resources\Management;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Management\ManagementSubjectResource;

class ManagementClassDetailResource extends JsonResource
{
    public $subjects;
    public $students;
    public $schedules;
    public function __construct($resource, $subjects, $students, $schedules)
    {
        parent::__construct($resource);
        $this->subjects = $subjects;
        $this->students = $students;
        $this->schedules = $schedules;
    }

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
            'course' => new ManagementCourseResource($this->whenLoaded('course')),
            'teacher' => new ManagementStaffResource($this->whenLoaded('teacher')),
            'subjects' => ManagementSubjectResource::collection($this->subjects),
            'students' => $this->students->map(function ($student) {
                return [
                    'id' => $student->id,
                    'student_id' => $student->student_id,
                    'first_name' => $student->first_name,
                    'last_name' => $student->last_name,
                    'email' => $student->email,
                    'phone' => $student->phone,
                    'gender' => $student->gender,
                    'date_of_birth' => $student->date_of_birth ? $student->date_of_birth->format('Y-m-d') : null,
                    'address' => $student->address,
                    'enrollment_date' => $student->enrollment_date ? $student->enrollment_date->format('Y-m-d') : null,
                    'status' => $student->status,
                    'guardian_info' => [
                        'name' => $student->guardian_name,
                        'phone' => $student->guardian_phone,
                        'relationship' => $student->guardian_relationship,
                    ],
                    'nrc' => $student->nrc,
                    'profile_photo' => $student->profile_photo,
                    'created_at' => $student->created_at->format('Y-m-d H:i:s'),
                    'updated_at' => $student->updated_at->format('Y-m-d H:i:s'),
                    'attendance' => $this->getRandomAttendancePercentage(),
                ];
            }),
            'schedules' => $this->schedules->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'subject' => [
                        'id' => $schedule->subject->id,
                        'title' => $schedule->subject->title,
                        'code' => $schedule->subject->code,
                    ],
                    'tutor' => [
                        'id' => $schedule->staff->id,
                        'first_name' => $schedule->staff->first_name,
                        'last_name' => $schedule->staff->last_name,
                        'email' => $schedule->staff->email,
                        'phone' => $schedule->staff->phone,
                    ],
                    'late_mins' => $schedule->late_mins,
                    'schedule_details' => [
                        'schedule_status' => $schedule->start_time->isPast() ? ($schedule->status === 'completed' ? 'completed' : ($schedule->status === 'cancelled' ? 'cancelled' : 'pending')) : 'ongoing',
                        'start_date' => $schedule->date && $schedule->start_time
                            ? $schedule->date->format('Y-m-d') . ' ' . $schedule->start_time->format('H:i:s')
                            : null,
                        'end_date' => $schedule->date && $schedule->end_time
                            ? $schedule->date->format('Y-m-d') . ' ' . $schedule->end_time->format('H:i:s')
                            : null,
                        'late_mins' => $schedule->late_mins,
                    ],
                ];
            }),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    // get random attendance percentage
    private function getRandomAttendancePercentage()
    {
        return rand(0, 100) . '%';
    }

}
