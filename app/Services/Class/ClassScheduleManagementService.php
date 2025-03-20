<?php

namespace App\Services\Class;

use App\Contracts\Services\ClassScheduleManagementServiceInterface;
use App\Contracts\Repositories\ClassScheduleRepositoryInterface;
use App\Contracts\Repositories\ClassRepositoryInterface;
use App\Models\Tenants\ClassSchedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\Collection;

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

    public function createSchedule(array $schedule): ClassSchedule
    {
        DB::beginTransaction();
        try {
            // Check if class exists and is ongoing
            $class = $this->classRepository->findById($schedule['class_id']);
            if (!$class || $class->status !== 'ongoing') {
                throw ValidationException::withMessages([
                    'class_id' => ['Class not found or not ongoing.']
                ]);
            }

            // finding conflict schedule for same class and same date
            $conflictSchedule = $this->scheduleRepository->findConflictSchedule($schedule['class_id'], $schedule['date'], $schedule['start_time'], $schedule['end_time']);

            if ($conflictSchedule) {
                throw ValidationException::withMessages([
                    'date' => ['Schedule already exists for this class and date.']
                ]);
            }

            $schedule = $this->scheduleRepository->create($schedule);

            DB::commit();
            return $schedule;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function createMultipleSchedules(array $schedules): Collection
    {
         $createdSchedules = new Collection();
        foreach ($schedules as $schedule) {
            $createdSchedules->push($this->createSchedule($schedule));
        }
        return $createdSchedules;
    }
}
