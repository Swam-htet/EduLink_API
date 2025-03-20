<?php

namespace App\Repositories;

use App\Contracts\Repositories\ClassScheduleRepositoryInterface;
use App\Models\Tenants\ClassSchedule;
use Illuminate\Database\Eloquent\Collection;

class ClassScheduleRepository implements ClassScheduleRepositoryInterface
{
    protected $model;

    public function __construct(ClassSchedule $model)
    {
        $this->model = $model;
    }

    public function getAll(): Collection
    {
        return $this->model->with(['class', 'class.teacher', 'staff'])->get();
    }

    public function findById(int $id): ?ClassSchedule
    {
        return $this->model->with(['class', 'class.teacher', 'staff'])->find($id);
    }

    public function create(array $data): ClassSchedule
    {
        $schedule = $this->model->create($data);
        return $schedule->load(['class', 'class.teacher', 'staff']);
    }

    public function getSchedulesByClassId(int $classId): Collection
    {
        return $this->model->with(['class', 'class.teacher', 'staff'])
            ->where('class_id', $classId)
            ->get();
    }
}
