<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Staff extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\StaffFactory> */
    use HasApiTokens, HasFactory, HasUuids, Notifiable, SoftDeletes;

    protected $table = 'staff';

    protected $fillable = [
        // Auth & Basic Info
        'email',
        'password',
        'is_active',
        'staff_id',
        'first_name',
        'last_name',
        'phone_number',
        'department',
        'designation',
        'date_of_birth',
        'gender',
        'address',
        'emergency_contact_name',
        'emergency_contact_phone',
        // Professional Info
        'qualification',
        'specialization',
        'joining_date',
        'salary',
        'bank_account_number',
        'bank_name',
        'profile_photo',
        'bio',
        'certifications',
        'teaching_subjects',
        'is_department_head',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'joining_date' => 'date',
        'email_verified_at' => 'datetime',
        'salary' => 'decimal:2',
        'is_department_head' => 'boolean',
        'is_active' => 'boolean',
        'certifications' => 'array',
        'teaching_subjects' => 'array',
        'password' => 'hashed',
    ];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
