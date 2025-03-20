<?php

namespace App\Services;

use App\Contracts\Services\StaffManagementServiceInterface;
use Illuminate\Support\Facades\DB;
use App\Models\Tenants\Staff;
use App\Contracts\Repositories\StaffRepositoryInterface;
use App\Contracts\Services\Mail\MailServiceInterface;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

class StaffManagementService implements StaffManagementServiceInterface
{
    protected $staffRepository;
    protected $mailService;

    public function __construct(StaffRepositoryInterface $staffRepository, MailServiceInterface $mailService)
    {
        $this->staffRepository = $staffRepository;
        $this->mailService = $mailService;
    }

    /**
     * Get all staff members
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllStaffs(array $filters) : LengthAwarePaginator
    {
        return $this->staffRepository->getAll($filters);
    }

    /**
     * Get staff member by id
     *
     * @param int $id
     * @return Staff
     */
    public function getStaffById(int $id) : Staff
    {
        return $this->staffRepository->getById($id);
    }

    /**
     * Create a new staff member
     *
     * @param array $data
     * @return Staff
     */
    public function createStaff(array $data) : Staff
    {
        // Generate random password
        // todo : need to generate random password with uppercase, lowercase, numbers and special characters
        $data['password'] = "Password$123S";

        try {
            DB::beginTransaction();
            $staff = $this->staffRepository->create($data);

            DB::commit();

            // todo : send reset password email link with token and expiry time to staff by using mail service

            return $staff;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
