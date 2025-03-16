<?php

namespace App\Repositories;

use App\Contracts\Repositories\StaffRepositoryInterface;
use App\Models\Tenants\Staff;
use Exception;
use Illuminate\Support\Facades\Log;

class StaffRepository implements StaffRepositoryInterface
{
    protected $model;

    public function __construct(Staff $model)
    {
        $this->model = $model;
    }

    /**
     * Get all staff members
     *
     * @return array
     */
    public function getAll() : array
    {
        return $this->model->all()->toArray();
    }

    /**
     * Get staff member by id
     *
     * @param int $id
     * @return Staff
     */
    public function getById(int $id) : Staff
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new staff member
     *
     * @param array $data
     * @return Staff
    * @throws Exception
     */
    public function create(array $data): Staff
{
    try {
        // Create staff
        $staff = $this->model->create($data);
        return $staff;

    } catch (Exception $e) {
        Log::error('Unexpected error while creating staff', ['error' => $e->getMessage()]);

        throw $e;
        }
    }
}
