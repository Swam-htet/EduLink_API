<?php

namespace App\Contracts\Services;

use App\Http\Requests\Staff\LoginRequest;
use App\Http\Requests\Staff\RegisterRequest;
use App\Models\Staff;
use Illuminate\Http\Request;

interface StaffAuthServiceInterface
{

    public function register(RegisterRequest $request): array;

    public function login(LoginRequest $request): array;

    public function logout(Request $request): bool;

    public function getProfile(Request $request): Staff;
}
