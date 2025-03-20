<?php

namespace App\Contracts\Repositories;

use App\Models\Tenants\Classes;
use Illuminate\Pagination\LengthAwarePaginator;

interface ClassRepositoryInterface
{
    /**
     * Get all classes
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAll(array $filters): LengthAwarePaginator;

    /**
     * Find class by ID
     *
     * @param int $id
     * @return Classes|null
     */
    public function findById(int $id): ?Classes;

    /**
     * Create new class
     *
     * @param array $data
     * @return Classes
     */
    public function create(array $data): Classes;

    /**
     * Update class
     *
     * @param int $id
     * @param array $data
     * @return Classes
     */
    public function update(int $id, array $data): Classes;
}