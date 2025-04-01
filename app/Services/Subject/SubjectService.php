<?php

namespace App\Services\Subject;

use App\Contracts\Services\SubjectServiceInterface;
use App\Contracts\Repositories\SubjectRepositoryInterface;
use App\Models\Tenants\Subject;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class SubjectService implements SubjectServiceInterface
{
    protected $subjectRepository;

    public function __construct(SubjectRepositoryInterface $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * Get all active subjects
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
        $subject = $this->subjectRepository->findById($id);

        if (!$subject) {
            throw ValidationException::withMessages([
                'id' => ['Subject not found or not active.']
            ]);
        }

        return $subject;
    }
}
