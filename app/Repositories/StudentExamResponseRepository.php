<?php

namespace App\Repositories;

use App\Contracts\Repositories\StudentExamResponseRepositoryInterface;
use App\Models\Tenants\StudentExamResponse;
use Illuminate\Support\Collection;

class StudentExamResponseRepository implements StudentExamResponseRepositoryInterface
{
    protected $model;

    public function __construct(StudentExamResponse $model)
    {
        $this->model = $model;
    }

    public function create(array $data): StudentExamResponse
    {
        return $this->model->create($data);
    }

    public function getAnswersByQuestionIdsAndStudentId(array $question_ids, int $studentId): Collection
    {
        return $this->model->whereIn('question_id', $question_ids)->where('student_id', $studentId)->get();
    }

    public function update(int $answerId, int $marks, string $comments): bool
    {
        return $this->model->where('id', $answerId)->update([
            'marks_obtained' => $marks,
            'is_correct' => true,
            'grading_comments' => $comments
        ]);
    }
}
