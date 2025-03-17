<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Classes;
use Illuminate\Database\Eloquent\Collection;

interface ClassManagementServiceInterface
{
    /**
     * Get all classes
     *
     * @return Collection
     */
    public function getAllClasses(): Collection;

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
