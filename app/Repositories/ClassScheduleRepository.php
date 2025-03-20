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
        return $this->model->with(['class', 'class.teacher', 'staff', 'subject'])->get();
    }

    public function findById(int $id): ?ClassSchedule
    {
        return $this->model->with(['class', 'class.teacher', 'staff', 'subject'])->find($id);
    }

    public function create(array $data): ClassSchedule
    {
        $schedule = $this->model->create($data);
        return $schedule->load(['class', 'class.teacher', 'staff', 'subject']);
    }

    public function getSchedulesByClassId(int $classId): Collection
    {
        return $this->model->with(['class', 'class.teacher', 'staff', 'subject'])
            ->where('class_id', $classId)
            ->get();
    }

    public function findConflictSchedule(int $classId, string $date, string $startTime, string $endTime): ?ClassSchedule
    {
        $conflictSchedule = $this->model->with(['class'])
            ->where('class_id', $classId)
            ->where('date', $date)
            ->where('start_time', '<=', $startTime)
            ->where('end_time', '>=', $endTime)
            ->first();

        return $conflictSchedule;
    }

}
