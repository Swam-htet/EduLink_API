<?php

namespace App\Repositories;

use App\Contracts\Repositories\SubjectRepositoryInterface;
use App\Models\Tenants\Subject;
use Illuminate\Database\Eloquent\Collection;

class SubjectRepository implements SubjectRepositoryInterface
{
    protected $model;

    public function __construct(Subject $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->with('course')->get();
    }

    public function findById(int $id): ?Subject
    {
        return $this->model->with('course')->find($id);
    }

    public function create(array $data): Subject
    {
        $data['code'] = $this->generateSubjectCode();
        $data['status'] = 'active';
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Subject
    {
        $subject = $this->findById($id);
        $subject->update($data);
        return $subject->fresh();
    }

    public function getAllActive(): Collection
    {
        return $this->model->with('course')
            ->where('status', 'active')
            ->get();
    }

    public function findActiveById(int $id): ?Subject
    {
        return $this->model->with('course')
            ->where('status', 'active')
            ->find($id);
    }

    // generate subject code
    private function generateSubjectCode(): string
    {
        $prefix = 'SB';
        $code = $prefix . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        return $code;
    }
}
