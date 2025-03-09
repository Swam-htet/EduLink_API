<?php

namespace App\Contracts\Services;

use App\Http\Requests\Staff\LoginRequest;
use App\Http\Requests\Staff\RegisterRequest;
use App\Models\Staff;
use Illuminate\Http\Request;

interface StaffAuthServiceInterface
{
    /**
     * Register a new staff member
     *
     * @param RegisterRequest $request
     * @return array
     */
    public function register(RegisterRequest $request): array;

    /**
     * Login a staff member
     *
     * @param LoginRequest $request
     * @return array
     */
    public function login(LoginRequest $request): array;

    /**
     * Logout a staff member
     *
     * @param Request $request
     * @return bool
     */
    public function logout(Request $request): bool;

    /**
     * Get staff profile
     *
     * @param Request $request
     * @return Staff
     */
    public function getProfile(Request $request): Staff;
}
