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
    public function getAllActiveSubjects(array $filters): Collection;

    /**
     * Get active subject by ID
     *
     * @param int $id
     * @return Subject
     */
    public function getActiveSubjectById(int $id): Subject;
}
