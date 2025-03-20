<?php

namespace App\Services\Class;

use App\Contracts\Services\ClassScheduleManagementServiceInterface;
use App\Contracts\Repositories\ClassScheduleRepositoryInterface;
use App\Contracts\Repositories\ClassRepositoryInterface;
use App\Models\Tenants\ClassSchedule;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ClassScheduleManagementService implements ClassScheduleManagementServiceInterface
{
    protected $scheduleRepository;
    protected $classRepository;

    public function __construct(
        ClassScheduleRepositoryInterface $scheduleRepository,
        ClassRepositoryInterface $classRepository
    ) {
        $this->scheduleRepository = $scheduleRepository;
        $this->classRepository = $classRepository;
    }

    public function getAllSchedules(): Collection
    {
        return $this->scheduleRepository->getAll();
    }

    public function getScheduleById(int $id): ClassSchedule
    {
        $schedule = $this->scheduleRepository->findById($id);

        if (!$schedule) {
            throw ValidationException::withMessages([
                'id' => ['Schedule not found.']
            ]);
        }

        return $schedule;
    }

    public function createSchedule(array $data): ClassSchedule
    {
        DB::beginTransaction();
        try {
            // Check if class exists and is ongoing
            $class = $this->classRepository->findById($data['class_id']);
            if (!$class || $class->status !== 'ongoing') {
                throw ValidationException::withMessages([
                    'class_id' => ['Class not found or not ongoing.']
                ]);
            }

            // todo : Check for schedule conflicts with date, start_time, end_time


            $schedule = $this->scheduleRepository->create($data);

            DB::commit();
            return $schedule;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
