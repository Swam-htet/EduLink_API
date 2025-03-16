<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Contracts\Services\StudentAuthServiceInterface;
use Illuminate\Http\Request;


class StudentAuthController extends Controller
{

    public function __construct(protected StudentAuthServiceInterface $studentAuthService)
    {
    }

    // login
    public function login(Request $request)
    {
        return $this->studentAuthService->login($request->all());
    }

    // logout
    public function logout(Request $request)
    {
        return $this->studentAuthService->logout($request->all());
    }

    // get profile
    public function getProfile(Request $request)
    {
        return $this->studentAuthService->getProfile($request->all());
    }






}
