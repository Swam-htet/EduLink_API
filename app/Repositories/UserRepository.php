<?php

namespace App\Repositories;

use App\Models\User;
use App\Services\TenantService;

class UserRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
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
        $this->model = new User();
    }

    /**
     * Find a user by email
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }
}
