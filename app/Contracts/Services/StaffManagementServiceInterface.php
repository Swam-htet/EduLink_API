<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Staff;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
interface StaffManagementServiceInterface
{
    /**
     * Get all staff members
     *
     * @param array $filters
     * @return Collection
     */
    public function getAllStaffs(array $filters) : LengthAwarePaginator;

    /**
     * Get staff member by id
     *
     * @param int $id
     * @return Staff
     */
    public function getStaffById(int $id) : Staff;

    /**
     * Create a new staff member
     *
     * @param array $data
     * @return array
     */
    public function createStaff(array $data) : Staff;
}
