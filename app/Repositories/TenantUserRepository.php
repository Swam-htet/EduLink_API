<?php

namespace App\Repositories;

use App\Models\TenantUser;
use App\Services\TenantService;

class TenantUserRepository extends BaseRepository
{
    /**
     * TenantUserRepository constructor.
     *
     * @param TenantService $tenantService
     */
    public function __construct(TenantService $tenantService)
    {
        parent::__construct($tenantService);
    }

    /**
     * Set model
     *
     * @return void
     */
    protected function setModel(): void
    {
        $this->model = new TenantUser();
    }

    /**
     * Find a user by email
     *
     * @param string $email
     * @return TenantUser|null
     */
    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    /**
     * Find users by role
     *
     * @param string $role
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByRole(string $role)
    {
        return $this->model->where('role', $role)->get();
    }
}
