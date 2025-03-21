<?php

namespace App\Repositories;

use App\Contracts\Repositories\ExamSectionRepositoryInterface;
use App\Models\Tenants\ExamSection;

class ExamSectionRepository implements ExamSectionRepositoryInterface
{
    protected $model;

    public function __construct(ExamSection $model)
    {
        $this->model = $model;
    }
}
