<?php

namespace App\Contracts\Repositories;

use App\Models\Tenants\Exam;
use Illuminate\Pagination\LengthAwarePaginator;

interface ExamRepositoryInterface
{
    public function getPaginatedExams(array $filters): LengthAwarePaginator;

    public function create(array $data): Exam;

    public function findById(int $id): Exam;

    public function update(int $id, array $data): Exam;
}
