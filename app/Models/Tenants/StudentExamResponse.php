<?php

namespace App\Models\Tenants;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Tenants\Traits\UsesTenantConnection;
class StudentExamResponse extends Model
{
    use SoftDeletes, UsesTenantConnection;

    protected $fillable = [
        'student_id',
        'question_id',
        'selected_choice',
        'written_answer',
        'matching_answers',
        'ordering_answer',
        'fill_in_blank_answers',
        'is_correct',
        'marks_obtained',
        'grading_comments',
    ];

    protected $casts = [
        'matching_answers' => 'json',
        'ordering_answer' => 'json',
        'fill_in_blank_answers' => 'json',
        'is_correct' => 'boolean',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(ExamQuestion::class, 'question_id');
    }

    public function gradedBy(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'graded_by');
    }
}
