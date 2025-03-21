<?php

namespace App\Repositories;

use App\Contracts\Repositories\ExamRepositoryInterface;
use App\Models\Tenants\Exam;

class ExamRepository implements ExamRepositoryInterface
{
    protected $model;

    public function __construct(Exam $model)
    {
        $this->model = $model;
    }
}
