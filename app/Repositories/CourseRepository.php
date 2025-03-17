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

    public function getAll(): Collection
    {
        return $this->model->all();
    }

    public function getAllActiveCourses(): Collection
    {
        return $this->model->where('status', 'active')->get();
    }

    public function findById(int $id): ?Course
    {
        return $this->model->find($id);
    }

    public function create(array $data): Course
    {
        // default status is active
        $data['status'] = 'active';
        $data['code'] = $this->generateCourseCode();
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Course
    {
        $course = $this->findById($id);
        $course->update($data);
        return $course->fresh();
    }

    public function delete(int $id): bool
    {
        return (bool) $this->model->destroy($id);
    }

    // generate course code
    private function generateCourseCode(): string
    {
        $prefix = 'CR';
        $code = $prefix . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        return $code;
    }
}
