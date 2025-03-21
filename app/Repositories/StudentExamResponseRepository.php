<?php

namespace App\Repositories;

use App\Contracts\Repositories\StudentExamResponseRepositoryInterface;
use App\Models\Tenants\StudentExamResponse;

class StudentExamResponseRepository implements StudentExamResponseRepositoryInterface
{
    protected $model;

    public function __construct(StudentExamResponse $model)
    {
        $this->model = $model;
    }
}
