<?php

namespace App\Services\Class;

use App\Contracts\Services\ClassManagementServiceInterface;
use App\Contracts\Repositories\ClassRepositoryInterface;
use App\Models\Tenants\Classes;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class ClassManagementService implements ClassManagementServiceInterface
{
    protected $classRepository;

    public function __construct(ClassRepositoryInterface $classRepository)
    {
        $this->classRepository = $classRepository;
    }

    /**
     * Get all classes
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getAllClasses(array $filters): LengthAwarePaginator
    {
        return $this->classRepository->getAll($filters);
    }

    /**
     * Get class by id
     * @param int $id
     * @return Classes
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

    /**
     * Create a new class
     * @param array $data
     * @return Classes
     */
    public function createClass(array $data): Classes
    {
        return $this->classRepository->create($data);
    }

    /**
     * Update a class
     * @param int $id
     * @param array $data
     * @return Classes
     */
    public function updateClass(int $id, array $data): Classes
    {
        $this->getClassById($id); // Validate existence
        return $this->classRepository->update($id, $data);
    }
}
