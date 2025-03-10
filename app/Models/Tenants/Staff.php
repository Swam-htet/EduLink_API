<?php

namespace App\Models\Tenants;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    use SoftDeletes;

    protected $table = 'staff';

    protected $fillable = [
        'staff_id',
        'name',
        'email',
        'phone',
        'gender',
        'date_of_birth',
        'address',
        'position',
        'employment_type',
        'joined_date',
        'status',
        'qualifications',
        'subjects',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'joined_date' => 'date',
        'qualifications' => 'json',
        'subjects' => 'json',
    ];

    // Relationships
    public function classSchedules(): HasMany
    {
        return $this->hasMany(ClassSchedule::class);
    }
}
