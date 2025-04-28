<?php

namespace App\Models\Tenants;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Tenants\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Tenants\StudentExamResponse;

class ExamResult extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $fillable = [
        'exam_id',
        'student_id',
        'total_marks_obtained',
        'total_questions',
        'correct_answers',
        'wrong_answers',
        'condition',
        'status',
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
