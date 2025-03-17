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

    public function getAllActiveSubjects(): Collection
    {
        return $this->subjectRepository->getAllActive();
    }

    public function getActiveSubjectById(int $id): Subject
    {
        $subject = $this->subjectRepository->findActiveById($id);

        if (!$subject) {
            throw ValidationException::withMessages([
                'id' => ['Subject not found or not active.']
            ]);
        }

        return $subject;
    }
}
