<?php

namespace App\Repositories;

use App\Contracts\Repositories\ExamQuestionRepositoryInterface;
use App\Models\Tenants\ExamQuestion;

class ExamQuestionRepository implements ExamQuestionRepositoryInterface
{
    protected $model;

    public function __construct(ExamQuestion $model)
    {
        $this->model = $model;
    }
}
