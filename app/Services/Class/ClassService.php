<?php

namespace App\Services\Class;

use App\Contracts\Services\ClassServiceInterface;
use App\Contracts\Repositories\ClassRepositoryInterface;
use App\Models\Tenants\Classes;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class ClassService implements ClassServiceInterface
{
    protected $classRepository;

    public function __construct(ClassRepositoryInterface $classRepository)
    {
        $this->classRepository = $classRepository;
    }

    /**
     * Get all active classes
     *
     * @return Collection
     */
    public function getAllClasses(): Collection
    {
        return $this->classRepository->getAll();
    }

    /**
     * Get active class by ID
     *
     * @param int $id
     * @return Classes
     * @throws ValidationException
     */
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
}
