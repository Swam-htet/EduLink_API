<?php

namespace App\Repositories;

use App\Models\Tenants\Student;
use App\Contracts\Repositories\StudentRepositoryInterface;

class StudentRepository implements StudentRepositoryInterface
{
    protected $model;

    public function __construct(Student $model)
    {
        $this->model = $model;
    }
}