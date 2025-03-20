<?php

namespace App\Services\Class;

use App\Contracts\Services\ClassServiceInterface;
use App\Contracts\Repositories\ClassRepositoryInterface;
use App\Models\Tenants\Classes;
use Illuminate\Pagination\LengthAwarePaginator;
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
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllClasses(array $filters): LengthAwarePaginator
    {
        return $this->classRepository->getAll($filters);
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
