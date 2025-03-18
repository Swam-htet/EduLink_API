<?php

namespace App\Models\Tenants;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Tenants\Traits\UsesTenantConnection;

class StudentClassEnrollment extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $fillable = [
        'student_id',
        'class_id',
        'enrolled_at',
        'status',
        'remarks',
    ];

    protected $casts = [
        'enrolled_at' => 'date',
    ];

    // Relationships
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
