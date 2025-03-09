<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Student extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasApiTokens, HasFactory, HasUuids, Notifiable, SoftDeletes;

    protected $fillable = [
        // Auth & Basic Info
        'email',
        'password',
        'is_active',
        'student_id',
        'first_name',
        'last_name',
        'phone_number',
        'date_of_birth',
        'gender',
        'address',
        // Parent Info
        'parent_name',
        'parent_phone',
        'parent_email',
        'parent_occupation',
        'parent_address',
        'emergency_contact_name',
        'emergency_contact_phone',
        // Academic Info
        'enrollment_date',
        'blood_group',
        'achievements',
        // Documents
        'profile_photo',
        'birth_certificate',
        'previous_school_records',
        'medical_records',
        // Additional Info
        'bio',
        'nationality',
        'religion',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'enrollment_date' => 'date',
        'email_verified_at' => 'datetime',
        'achievements' => 'array',
        'is_active' => 'boolean',
        'password' => 'hashed',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
