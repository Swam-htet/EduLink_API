<?php

namespace App\Services\Subject;

use App\Contracts\Services\SubjectManagementServiceInterface;
use App\Contracts\Repositories\SubjectRepositoryInterface;
use App\Models\Tenants\Subject;
use Illuminate\Database\Eloquent\Collection;

class SubjectManagementService implements SubjectManagementServiceInterface
{
    protected $subjectRepository;

    public function __construct(SubjectRepositoryInterface $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * Get all subjects
     * @return Collection
     */
    public function getAllSubjects(array $filters): Collection
    {
        return $this->subjectRepository->getAll($filters);
    }

    /**
     * Get subject by id
     * @param int $id
     * @return Subject|null
     */
    public function getSubjectById(int $id): Subject
    {
        return $this->subjectRepository->findById($id);
    }

    /**
     * Create a new subject
     * @param array $data
     * @return Subject
     */
    public function createSubject(array $data): Subject
    {
        return $this->subjectRepository->create($data);
    }

    /**
     * Update a subject
     * @param int $id
     * @param array $data
     * @return Subject
     */
    public function updateSubject(int $id, array $data): Subject
    {
        return $this->subjectRepository->update($id, $data);
    }

    /**
     * Delete a subject
     * @param int $id
     * @return void
     */
    public function deleteSubject(int $id): void
    {
        $this->subjectRepository->delete($id);
    }

    /**
     * Get all subjects by course ID
     * @param int $courseId
     * @return Collection
     */
    public function getAllSubjectsByCourseId(int $courseId): Collection
    {
        return $this->subjectRepository->getAllByCourseId($courseId);
    }
}
