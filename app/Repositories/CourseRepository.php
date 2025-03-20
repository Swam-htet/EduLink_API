<?php

namespace App\Repositories;

use App\Contracts\Repositories\CourseRepositoryInterface;
use App\Models\Tenants\Course;
use Illuminate\Database\Eloquent\Collection;


class CourseRepository implements CourseRepositoryInterface
{
    protected $model;

    public function __construct(Course $model)
    {
        $this->model = $model;
    }

    /**
     * Get all courses
     * @return Collection
     */
    public function getAll(array $filters): Collection
    {
        $query = $this->model->query();

        if (isset($filters['title'])) {
            $query->where('title', 'like', "%{$filters['title']}%");
        }

        if (isset($filters['code'])) {
            $query->where('code', 'like', "%{$filters['code']}%");
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $query->orderBy($filters['sort_by'] ?? 'created_at', $filters['sort_direction'] ?? 'desc');

        return $query->get();
    }

    /**
     * Get all active courses
     * @return Collection
     */
    public function getAllActiveCourses(array $filters): Collection
    {
        $query = $this->model->query();

        if (isset($filters['title'])) {
            $query->where('title', 'like', "%{$filters['title']}%");
        }

        if (isset($filters['code'])) {
            $query->where('code', 'like', "%{$filters['code']}%");
        }

        // status is active
        $query->where('status', 'active');

        $query->orderBy($filters['sort_by'] ?? 'created_at', $filters['sort_direction'] ?? 'desc');

        return $query->get();
    }

    /**
     * Get course by id
     * @param int $id
     * @return Course|null
     */
    public function findById(int $id): ?Course
    {
        return $this->model->find($id);
    }

    /**
     * Create a new course
     * @param array $data
     * @return Course
     */
    public function create(array $data): Course
    {
        // default status is active
        $data['status'] = 'active';
        $data['code'] = $this->generateCourseCode();
        return $this->model->create($data);
    }

    /**
     * Update a course
     * @param int $id
     * @param array $data
     * @return Course
     */
    public function update(int $id, array $data): Course
    {
        $course = $this->findById($id);
        $course->update($data);
        return $course->fresh();
    }

    /**
     * Delete a course
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return (bool) $this->model->destroy($id);
    }

    /**
     * Generate course code
     * @return string
     */
    private function generateCourseCode(): string
    {
        $prefix = 'CR';
        $code = $prefix . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        return $code;
    }
}
