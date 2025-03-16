<?php

namespace App\Models\Tenants;

use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Tenants\Traits\UsesTenantConnection;

class Staff extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, UsesTenantConnection;

    protected $fillable = [
        'staff_id',
        'name',
        'email',
        'password',
        'phone',
        'gender',
        'date_of_birth',
        'address',
        'type',
        'nrc',
        'profile_photo',
        'joined_date',
        'status',
        'qualifications',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'joined_date' => 'date',
        'qualifications' => 'json',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function classSchedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class);
    }
}
