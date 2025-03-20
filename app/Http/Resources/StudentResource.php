<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'student_id' => $this->student_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth ? $this->date_of_birth->format('Y-m-d') : null,
            'address' => $this->address,
            'enrollment_date' => $this->enrollment_date ? $this->enrollment_date->format('Y-m-d') : null,
            'guardian_info' => [
                'name' => $this->guardian_name,
                'phone' => $this->guardian_phone,
                'relationship' => $this->guardian_relationship,
            ],
            'nrc' => $this->nrc,
            'profile_photo' => $this->profile_photo,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
