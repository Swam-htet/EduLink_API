<?php

namespace App\Services\Course;

use App\Contracts\Services\CourseManagementServiceInterface;
use App\Contracts\Repositories\CourseRepositoryInterface;
use App\Models\Tenants\Course;
use Illuminate\Database\Eloquent\Collection;

class CourseManagementService implements CourseManagementServiceInterface
{
    protected $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * Get all courses
     * @param array $filters
     * @return Collection
     */
    public function getAllCourses(array $filters): Collection
    {
        return $this->courseRepository->getAll($filters);
    }

    /**
     * Get course by id
     * @param int $id
     * @return Course|null
     */
    public function getCourseById(int $id): Course
    {
        return $this->courseRepository->findById($id);
    }

    /**
     * Create a new course
     * @param array $data
     * @return Course
     */
    public function createCourse(array $data): Course
    {
        return $this->courseRepository->create($data);
    }

    /**
     * Update a course
     * @param int $id
     * @param array $data
     * @return Course
     */
    public function updateCourse(int $id, array $data): Course
    {
        return $this->courseRepository->update($id, $data);
    }

    /**
     * Delete a course
     * @param int $id
     * @return bool
     */
    public function deleteCourse(int $id): bool
    {
        return $this->courseRepository->delete($id);
    }
}
