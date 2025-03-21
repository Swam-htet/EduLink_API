<?php

namespace App\Models\Tenants;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentExamResponse extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'exam_id',
        'student_id',
        'question_id',
        'selected_choice',
        'written_answer',
        'matching_answers',
        'ordering_answer',
        'fill_in_blank_answers',
        'is_correct',
        'marks_obtained',
        'needs_grading',
        'grading_comments',
        'graded_by',
        'graded_at',
        'started_at',
        'answered_at',
        'time_taken',
    ];

    protected $casts = [
        'matching_answers' => 'json',
        'ordering_answer' => 'json',
        'fill_in_blank_answers' => 'json',
        'is_correct' => 'boolean',
        'needs_grading' => 'boolean',
        'graded_at' => 'datetime',
        'started_at' => 'datetime',
        'answered_at' => 'datetime',
    ];

    public function exam(): BelongsTo
    {
        return $this->belongsTo(Exam::class);
    }

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
