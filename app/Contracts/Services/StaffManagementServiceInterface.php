<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Staff;

interface StaffManagementServiceInterface
{
    /**
     * Get all staff members
     *
     * @return array
     */
    public function getAllStaffs() : array;

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
