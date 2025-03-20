<?php

namespace App\Repositories;

use App\Contracts\Repositories\SubjectRepositoryInterface;
use App\Models\Tenants\Subject;
use Illuminate\Database\Eloquent\Collection;

class SubjectRepository implements SubjectRepositoryInterface
{
    protected $model;

    public function __construct(Subject $model)
    {
        $this->model = $model;
    }

    /**
     * Get all subjects
     * @return Collection
     */
    public function getAll(array $filters): Collection
    {
        $query = $this->model->with('course');

        if (isset($filters['course_id'])) {
            $query->where('course_id', $filters['course_id']);
        }

        if (isset($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (isset($filters['code'])) {
            $query->where('code', 'like', '%' . $filters['code'] . '%');
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['credits'])) {
            $query->where('credits', $filters['credits']);
        }

        if (isset($filters['sort_by'])) {
            $query->orderBy($filters['sort_by'], $filters['sort_direction']);
        }

        if (isset($filters['sort_direction'])) {
            $query->orderBy($filters['sort_by'], $filters['sort_direction']);
        }

        return $query->get();
    }

    /**
     * Get subject by id
     * @param int $id
     * @return Subject|null
     */
    public function findById(int $id): ?Subject
    {
        return $this->model->with('course')->find($id);
    }

    /**
     * Create a new subject
     * @param array $data
     * @return Subject
     */
    public function create(array $data): Subject
    {
        $data['code'] = $this->generateSubjectCode();
        $data['status'] = 'active';
        return $this->model->create($data);
    }

    /**
     * Update a subject
     * @param int $id
     * @param array $data
     * @return Subject
     */
    public function update(int $id, array $data): Subject
    {
        $subject = $this->findById($id);
        $subject->update($data);
        return $subject->fresh();
    }

    /**
     * Get all active subjects
     * @return Collection
     */
    public function getAllActive(array $filters): Collection
    {
        $query = $this->model->with('course')
            ->where('status', 'active');

        if (isset($filters['course_id'])) {
            $query->where('course_id', $filters['course_id']);
        }

        if (isset($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (isset($filters['code'])) {
            $query->where('code', 'like', '%' . $filters['code'] . '%');
        }

        if (isset($filters['sort_by'])) {
            $query->orderBy($filters['sort_by'], $filters['sort_direction']);
        }

        if (isset($filters['sort_direction'])) {
            $query->orderBy($filters['sort_by'], $filters['sort_direction']);
        }

        return $query->get();
    }

    /**
     * Get active subject by id
     * @param int $id
     * @return Subject|null
     */
    public function findActiveById(int $id): ?Subject
    {
        return $this->model->with('course')
            ->where('status', 'active')
            ->find($id);
    }


    /**
     * Generate subject code
     * @return string
     */
    private function generateSubjectCode(): string
    {
        $prefix = 'SB';
        $code = $prefix . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        return $code;
    }
}
