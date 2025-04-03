<?php

namespace App\Repositories;

use App\Contracts\Repositories\ExamRepositoryInterface;
use App\Models\Tenants\Exam;
use Illuminate\Pagination\LengthAwarePaginator;

class ExamRepository implements ExamRepositoryInterface
{
    protected $model;

    public function __construct(Exam $model)
    {
        $this->model = $model;
    }

    public function getPaginatedExams(array $filters): LengthAwarePaginator
    {
        $query = $this->model->query();

        if (isset($filters['class_id'])) {
            $query->where('class_id', $filters['class_id']);
        }

        if (isset($filters['subject_id'])) {
            $query->where('subject_id', $filters['subject_id']);
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (isset($filters['exam_date'])) {
            $query->where('exam_date', $filters['exam_date']);
        }

        if (isset($filters['start_time']) && isset($filters['end_time'])) {
            $query->whereBetween('start_time', [$filters['start_time'], $filters['end_time']]);
        }

        if (isset($filters['sort_by'])) {
            $query->orderBy($filters['sort_by'], $filters['sort_direction'] ?? 'asc');
        }

        $query->with('class', 'subject');

        return $query->paginate($filters['per_page'] ?? 10, ['*'], 'page', $filters['current_page'] ?? 1);
    }

    public function create(array $data): Exam
    {
        return $this->model->create($data);
    }

    public function findById(int $id): Exam
    {
        return $this->model->findOrFail($id);
    }

    public function update(int $id, array $data): Exam
    {
        $exam = $this->findById($id);
        $exam->update($data);
        return $exam;
    }
}
