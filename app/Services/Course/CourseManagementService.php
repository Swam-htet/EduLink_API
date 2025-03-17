<?php

namespace App\Services\Course;

use App\Contracts\Services\CourseManagementServiceInterface;
use App\Contracts\Repositories\CourseRepositoryInterface;
use App\Models\Tenants\Course;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class CourseManagementService implements CourseManagementServiceInterface
{
    protected $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function getAllCourses(): Collection
    {
        return $this->courseRepository->getAll();
    }

    public function getCourseById(int $id): Course
    {
        return $this->courseRepository->findById($id);
    }

    public function createCourse(array $data): Course
    {
        return $this->courseRepository->create($data);
    }

    public function updateCourse(int $id, array $data): Course
    {
        return $this->courseRepository->update($id, $data);
    }

    public function deleteCourse(int $id): bool
    {
        return $this->courseRepository->delete($id);
    }
}
