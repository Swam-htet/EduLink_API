<?php

namespace App\Repositories;

use App\Contracts\Repositories\ClassRepositoryInterface;
use App\Models\Tenants\Classes;
use Illuminate\Pagination\LengthAwarePaginator;

class ClassRepository implements ClassRepositoryInterface
{
    protected $model;

    public function __construct(Classes $model)
    {
        $this->model = $model;
    }

    /**
     * Get all classes
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAll(array $filters): LengthAwarePaginator
    {
        $query = $this->model->query()->with(['course', 'teacher']);

        if (isset($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['code'])) {
            $query->where('code', 'like', '%' . $filters['code'] . '%');
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['course_id'])) {
            $query->where('course_id', $filters['course_id']);
        }

        if (isset($filters['subject_id'])) {
            $query->where('subject_id', $filters['subject_id']);
        }

        if (isset($filters['teacher_id'])) {
            $query->where('teacher_id', $filters['teacher_id']);
        }

        if (isset($filters['date_range'])) {
            $query->whereBetween('start_date', [$filters['date_range']['start'], $filters['date_range']['end']]);
        }

        if (isset($filters['capacity'])) {
            $query->where('capacity', $filters['capacity']);
        }

        if (isset($filters['sort_by'])) {
            $query->orderBy($filters['sort_by'], $filters['sort_direction']);
        }

        return $query->paginate($filters['per_page']);
    }

    /**
     * Get class by id
     * @param int $id
     * @return Classes|null
     */
    public function findById(int $id): ?Classes
    {
        return $this->model->with(['course', 'teacher'])->find($id);
    }

    /**
     * Create a new class
     * @param array $data
     * @return Classes
     */
    public function create(array $data): Classes
    {
        $data['code'] = $this->generateClassCode();
        return $this->model->create($data);
    }

    /**
     * Update a class
     * @param int $id
     * @param array $data
     * @return Classes
     */
    public function update(int $id, array $data): Classes
    {
        $class = $this->findById($id);
        $class->update($data);
        return $class->fresh();
    }

    /**
     * Generate class code
     * @return string
     */
    private function generateClassCode(): string
    {
        $prefix = 'CLS';
        $code = $prefix . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        return $code;
    }
}
