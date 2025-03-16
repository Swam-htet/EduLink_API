<?php

namespace App\Contracts\Repositories;

use App\Models\Tenants\Staff;

interface StaffRepositoryInterface
{
    /**
     * Get all staff members
     *
     * @return array
     */
    public function getAll() : array;

    /**
     * Get staff member by id
     *
     * @param int $id
     * @return Staff
     */
    public function getById(int $id) : Staff;

    /**
     * Create a new staff member
     *
     * @param array $data
     * @return Staff
     */
    public function create(array $data) : Staff;
}
