<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Classes;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
interface ClassManagementServiceInterface
{
    /**
     * Get all classes
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllClasses(array $filters): LengthAwarePaginator;

    /**
     * Get all ongoing classes
     *
     * @return Collection
     */
    public function getOngoingClasses(): Collection;

    /**
     * Get class by ID
     *
     * @param int $id
     * @return Classes
     */
    public function getClassById(int $id): Classes;

    /**
     * Create new class
     *
     * @param array $data
     * @return Classes
     */
    public function createClass(array $data): Classes;

    /**
     * Update class
     *
     * @param int $id
     * @param array $data
     * @return Classes
     */
    public function updateClass(int $id, array $data): Classes;
}
