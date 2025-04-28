<?php

namespace App\Contracts\Repositories;

use App\Models\Tenants\ClassSchedule;
use Illuminate\Database\Eloquent\Collection;

interface ClassScheduleRepositoryInterface
{
    /**
     * Get all schedules
     *
     * @param array $filters
     * @return Collection
     */
    public function getAll(array $filters): Collection;

    /**
     * Find schedule by ID
     *
     * @param int $id
     * @return ClassSchedule|null
     */
    public function findById(int $id): ?ClassSchedule;

    /**
     * Create new schedule
     *
     * @param array $data
     * @return ClassSchedule
     */
    public function create(array $data): ClassSchedule;

    /**
     * Get schedules by class ID
     *
     * @param int $classId
     * @return Collection
     */
    public function getSchedulesByClassId(int $classId): Collection;

    /**
     * Find conflict schedule
     *
     * @param int $classId
     * @param string $date
     * @param string $startTime
     * @param string $endTime
     * @return ClassSchedule|null
     */
    public function findConflictSchedule(int $classId, string $date, string $startTime, string $endTime): ?ClassSchedule;

    /**
     * Get all schedules by class ID
     *
     * @param int $classId
     * @return Collection
     */
    public function getAllByClassId(int $classId): Collection;
}
