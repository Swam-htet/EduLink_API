<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Classes;
use Illuminate\Database\Eloquent\Collection;

interface ClassServiceInterface
{
    /**
     * Get all active classes
     *
     * @return Collection
     */
    public function getAllClasses(): Collection;

    /**
     * Get active class by ID
     *
     * @param int $id
     * @return Classes
     */
    public function getClassById(int $id): Classes;
}
