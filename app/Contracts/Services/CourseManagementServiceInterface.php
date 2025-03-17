<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Course;
use Illuminate\Database\Eloquent\Collection;

interface CourseManagementServiceInterface
{
    /**
     * Get all courses
     *
     * @return Collection
     */
    public function getAllCourses(): Collection;

    /**
     * Get course by ID
     *
     * @param int $id
     * @return Course
     */
    public function getCourseById(int $id): Course;

    /**
     * Create new course
     *
     * @param array $data
     * @return Course
     */
    public function createCourse(array $data): Course;

    /**
     * Update course
     *
     * @param int $id
     * @param array $data
     * @return Course
     */
    public function updateCourse(int $id, array $data): Course;

    /**
     * Delete course
     *
     * @param int $id
     * @return bool
     */
    public function deleteCourse(int $id): bool;
}
