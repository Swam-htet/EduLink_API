<?php

namespace App\Repositories;

use App\Contracts\Repositories\StaffRepositoryInterface;
use App\Models\Tenants\Staff;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
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
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAll(array $filters) : LengthAwarePaginator
    {
        $query = $this->model->query();

        if (isset($filters['name'])) {
            $query->where(DB::raw('CONCAT(first_name, " ", last_name)'), 'like', '%' . $filters['name'] . '%');
        }

        if (isset($filters['email'])) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        }

        if (isset($filters['phone'])) {
            $query->where('phone', 'like', '%' . $filters['phone'] . '%');
        }

        if (isset($filters['nrc'])) {
            $query->where('nrc', 'like', '%' . $filters['nrc'] . '%');
        }

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        if (isset($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        if (isset($filters['date_of_birth'])) {
            $query->whereBetween('date_of_birth', [$filters['date_of_birth']['start'], $filters['date_of_birth']['end']]);
        }

        if (isset($filters['joined_date'])) {
            $query->whereBetween('joined_date', [$filters['joined_date']['start'], $filters['joined_date']['end']]);
        }

        if (isset($filters['sort_by'])) {
            if ($filters['sort_by'] == 'name') {
                $query->orderBy(DB::raw('CONCAT(first_name, " ", last_name)'), $filters['sort_direction']);
            } else {
                $query->orderBy($filters['sort_by'], $filters['sort_direction']);
            }
        }

        return $query->paginate($filters['per_page'], ['*'], 'page', $filters['current_page'] ?? 1);
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
        // hash password
        $data['password'] = Hash::make("Password$123S");

        // join date today
        $data['joined_date'] = now();

        // Create staff
        $staff = $this->model->create($data);
        return $staff;

    } catch (Exception $e) {
        Log::error('Unexpected error while creating staff', ['error' => $e->getMessage()]);

        throw $e;
        }
    }
}
