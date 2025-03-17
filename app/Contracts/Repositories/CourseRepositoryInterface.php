<?php

namespace App\Contracts\Repositories;

use App\Models\Tenants\Course;
use Illuminate\Database\Eloquent\Collection;

interface CourseRepositoryInterface
{
    /**
     * Get all courses with pagination
     *
     * @param array $filters
     * @return
     */
    public function getAll(): Collection;


    /**
     * Get all active courses
     *
     * @return Collection
     */
    public function getAllActiveCourses(): Collection;

    /**
     * Find course by ID
     *
     * @param int $id
     * @return Course|null
     */
    public function findById(int $id): ?Course;

    /**
     * Create new course
     *
     * @param array $data
     * @return Course
     */
    public function create(array $data): Course;

    /**
     * Update course
     *
     * @param int $id
     * @param array $data
     * @return Course
     */
    public function update(int $id, array $data): Course;

    /**
     * Delete course
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}