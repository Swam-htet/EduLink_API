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
    public function getAll(): Collection;

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
     * Get all active subjects
     *
     * @return Collection
     */
    public function getAllActive(): Collection;

    /**
     * Find active subject by ID
     *
     * @param int $id
     * @return Subject|null
     */
    public function findActiveById(int $id): ?Subject;
}
