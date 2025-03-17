<?php

namespace App\Services;

use App\Contracts\Services\StaffManagementServiceInterface;
use Illuminate\Support\Facades\DB;
use App\Models\Tenants\Staff;
use App\Contracts\Repositories\StaffRepositoryInterface;
use App\Exceptions\DataCreationException;
use Illuminate\Support\Facades\Hash;
use App\Contracts\Services\Mail\MailServiceInterface;
use Exception;

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
     * @return array
     */
    public function getAllStaffs() : array
    {
        return $this->staffRepository->getAll();
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
     * @return array
     * @throws DataCreationException
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
