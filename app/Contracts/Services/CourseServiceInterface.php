<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Course;
use Illuminate\Database\Eloquent\Collection;

interface CourseServiceInterface
{
    /**
     * Get all active courses with pagination
     *
     * @return Collection
     */
    public function getAllActiveCourses(array $filters): Collection;

    /**
     * Get active course by ID
     *
     * @param int $id
     * @return Course
     */
    public function getActiveCourseById(int $id): Course;
}
