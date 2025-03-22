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

        if (isset($filters['date_range'])) {
            $query->whereBetween('start_date', $filters['date_range']);
        }

        if (isset($filters['sort_by'])) {
            $query->orderBy($filters['sort_by'], $filters['sort_direction'] ?? 'asc');
        }

        return $query->paginate($filters['per_page'] ?? 10);
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
