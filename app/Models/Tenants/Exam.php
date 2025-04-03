<?php

namespace App\Models\Tenants;

use App\Models\Tenants\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exam extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $fillable = [
        'class_id',
        'subject_id',
        'title',
        'description',
        'total_marks',
        'pass_marks',
        'duration',
        'exam_date',
        'start_time',
        'end_time',
        'status',
    ];

    protected $casts = [
        'exam_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(StudentExamResponse::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(ExamResult::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(ExamSection::class);
    }
}
