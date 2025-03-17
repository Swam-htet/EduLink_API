<?php

namespace App\Services\Class;

use App\Contracts\Services\ClassManagementServiceInterface;
use App\Contracts\Repositories\ClassRepositoryInterface;
use App\Models\Tenants\Classes;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class ClassManagementService implements ClassManagementServiceInterface
{
    protected $classRepository;

    public function __construct(ClassRepositoryInterface $classRepository)
    {
        $this->classRepository = $classRepository;
    }

    public function getAllClasses(): Collection
    {
        return $this->classRepository->getAll();
    }

    public function getClassById(int $id): Classes
    {
        $class = $this->classRepository->findById($id);

        if (!$class) {
            throw ValidationException::withMessages([
                'id' => ['Class not found.']
            ]);
        }

        return $class;
    }

    public function createClass(array $data): Classes
    {
        return $this->classRepository->create($data);
    }

    public function updateClass(int $id, array $data): Classes
    {
        $this->getClassById($id); // Validate existence
        return $this->classRepository->update($id, $data);
    }
}
