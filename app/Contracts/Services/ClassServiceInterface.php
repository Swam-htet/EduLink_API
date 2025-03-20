<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Classes;
use Illuminate\Pagination\LengthAwarePaginator;

interface ClassServiceInterface
{
    /**
     * Get all active classes
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllClasses(array $filters): LengthAwarePaginator;

    /**
     * Get active class by ID
     *
     * @param int $id
     * @return Classes
     */
    public function getClassById(int $id): Classes;
}
