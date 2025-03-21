<?php

namespace App\Models\Tenants;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamResult extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'exam_id',
        'student_id',
        'total_marks_obtained',
        'total_questions',
        'correct_answers',
        'wrong_answers',
        'percentage',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'percentage' => 'decimal:2',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
