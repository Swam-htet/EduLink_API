<?php

namespace App\Contracts\Repositories;

use App\Models\Tenants\Subject;
use Illuminate\Database\Eloquent\Collection;

interface SubjectRepositoryInterface
{
    /**
     * Get all subjects
     *
     * @return Collection
     */
    public function getAll(array $filters): Collection;

    /**
     * Find subject by ID
     *
     * @param int $id
     * @return Subject|null
     */
    public function findById(int $id): ?Subject;

    /**
     * Create new subject
     *
     * @param array $data
     * @return Subject
     */
    public function create(array $data): Subject;

    /**
     * Update subject
     *
     * @param int $id
     * @param array $data
     * @return Subject
     */
    public function update(int $id, array $data): Subject;


    /**
     * Delete subject
     *
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;

    /**
     * Get all subjects by course ID
     *
     * @param int $courseId
     * @return Collection
     */
    public function getAllByCourseId(int $courseId): Collection;
}
