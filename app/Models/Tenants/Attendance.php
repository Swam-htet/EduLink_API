<?php

namespace App\Models\Tenants;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Tenants\Traits\UsesTenantConnection;

class Attendance extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $fillable = [
        'class_schedule_id',
        'student_id',
        'date',
        'status',
        'time_in',
        'time_out',
        'remarks',
    ];

    protected $casts = [
        'date' => 'date',
        'time_in' => 'datetime',
        'time_out' => 'datetime',
    ];

    // Relationships
    public function classSchedule(): BelongsTo
    {
        return $this->belongsTo(ClassSchedule::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
