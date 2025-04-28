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
            'schedules' => ManagementClassScheduleResource::collection($this->schedules),
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
