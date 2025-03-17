<?php

namespace App\Contracts\Repositories;

use App\Models\Tenants\Classes;
use Illuminate\Database\Eloquent\Collection;

interface ClassRepositoryInterface
{
    /**
     * Get all classes
     *
     * @return Collection
     */
    public function getAll(): Collection;

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