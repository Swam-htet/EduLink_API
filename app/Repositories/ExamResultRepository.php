<?php

namespace App\Repositories;

use App\Contracts\Repositories\ExamResultRepositoryInterface;
use App\Models\Tenants\ExamResult;

class ExamResultRepository implements ExamResultRepositoryInterface
{
    protected $model;

    public function __construct(ExamResult $model)
    {
        $this->model = $model;
    }
}
