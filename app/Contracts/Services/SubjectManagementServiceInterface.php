<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Subject;
use Illuminate\Database\Eloquent\Collection;

interface SubjectManagementServiceInterface
{
    /**
     * Get all subjects
     *
     * @return Collection
     */
    public function getAllSubjects(): Collection;

    /**
     * Get subject by ID
     *
     * @param int $id
     * @return Subject
     */
    public function getSubjectById(int $id): Subject;

    /**
     * Create new subject
     *
     * @param array $data
     * @return Subject
     */
    public function createSubject(array $data): Subject;

    /**
     * Update subject
     *
     * @param int $id
     * @param array $data
     * @return Subject
     */
    public function updateSubject(int $id, array $data): Subject;
}
