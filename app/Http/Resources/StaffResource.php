<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
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
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'nrc' => $this->nrc,
            'profile_photo' => $this->profile_photo,
            'date_of_birth' => $this->date_of_birth ? $this->date_of_birth->format('Y-m-d') : null,
            'address' => $this->address,
            'role' => $this->role,
            'joined_date' => $this->joined_date ? $this->joined_date->format('Y-m-d') : null,
            'qualifications' => $this->qualifications,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
