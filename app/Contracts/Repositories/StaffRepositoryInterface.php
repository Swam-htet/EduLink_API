<?php

namespace App\Contracts\Repositories;

use App\Models\Tenants\Staff;
use Illuminate\Pagination\LengthAwarePaginator;
interface StaffRepositoryInterface
{
    /**
     * Get all staff members
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAll(array $filters) : LengthAwarePaginator;

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
