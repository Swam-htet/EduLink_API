<?php

namespace App\Services\Subject;

use App\Contracts\Services\SubjectManagementServiceInterface;
use App\Contracts\Repositories\SubjectRepositoryInterface;
use App\Models\Tenants\Subject;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class SubjectManagementService implements SubjectManagementServiceInterface
{
    protected $subjectRepository;

    public function __construct(SubjectRepositoryInterface $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    public function getAllSubjects(): Collection
    {
        return $this->subjectRepository->getAll();
    }

    public function getSubjectById(int $id): Subject
    {
        return $this->subjectRepository->findById($id);
    }

    public function createSubject(array $data): Subject
    {
        return $this->subjectRepository->create($data);
    }

    public function updateSubject(int $id, array $data): Subject
    {
        return $this->subjectRepository->update($id, $data);
    }
}
