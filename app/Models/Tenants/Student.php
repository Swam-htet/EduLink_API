<?php

namespace App\Models\Tenants;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Tenants\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Passport\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes, UsesTenantConnection;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'gender',
        'address',
        'date_of_birth',
        'student_id',
        'status',
        'gender',
        'enrollment_date',
        'guardian_name',
        'guardian_phone',
        'guardian_relationship',
        'additional_info',
        'nrc',
        'profile_photo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date',
        'password' => 'hashed',
        'enrollment_date' => 'date',
        'additional_info' => 'json',
    ];

    public function classEnrollments(): HasMany
    {
        return $this->hasMany(StudentClassEnrollment::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
