<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Subject;
use Illuminate\Database\Eloquent\Collection;

interface SubjectServiceInterface
{
    /**
     * Get all active subjects
     *
     * @return Collection
     */
    public function getAllSubjects(array $filters): Collection;

    /**
     * Get active subject by ID
     *
     * @param int $id
     * @return Subject
     */
    public function getSubjectById(int $id): Subject;
}
