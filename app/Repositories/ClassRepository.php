<?php

namespace App\Repositories;

use App\Contracts\Repositories\ClassRepositoryInterface;
use App\Models\Tenants\Classes;
use Illuminate\Database\Eloquent\Collection;

class ClassRepository implements ClassRepositoryInterface
{
    protected $model;

    public function __construct(Classes $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->with(['course', 'teacher'])->get();
    }

    public function findById(int $id): ?Classes
    {
        return $this->model->with(['course', 'teacher'])->find($id);
    }

    public function create(array $data): Classes
    {
        $data['code'] = $this->generateClassCode();
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Classes
    {
        $class = $this->findById($id);
        $class->update($data);
        return $class->fresh();
    }

    private function generateClassCode(): string
    {
        $prefix = 'CLS';
        $code = $prefix . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        return $code;
    }
}
