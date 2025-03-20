<?php

namespace App\Services\Course;

use App\Contracts\Services\CourseServiceInterface;
use App\Contracts\Repositories\CourseRepositoryInterface;
use App\Models\Tenants\Course;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class CourseService implements CourseServiceInterface
{
    protected $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * Get all active courses with pagination
     *
     * @param array $filters
     * @return Collection
     */
    public function getAllActiveCourses(array $filters): Collection
    {
        return $this->courseRepository->getAllActiveCourses($filters);
    }

    /**
     * Get active course by ID
     *
     * @param int $id
     * @return Course
     * @throws ValidationException
     */
    public function getActiveCourseById(int $id): Course
    {
        $course = $this->courseRepository->findById($id);

        if (!$course || $course->status !== 'active') {
            throw ValidationException::withMessages([
                'id' => ['Course not found or not active.']
            ]);
        }

        return $course;
    }
}
