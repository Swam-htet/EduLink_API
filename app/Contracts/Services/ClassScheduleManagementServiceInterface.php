<?php

namespace App\Contracts\Services;

use App\Models\Tenants\ClassSchedule;
use Illuminate\Database\Eloquent\Collection;

interface ClassScheduleManagementServiceInterface
{
    /**
     * Get all schedules
     *
     * @return Collection
     */
    public function getAllSchedules(array $filters): Collection;

    /**
     * Get schedule by ID
     *
     * @param int $id
     * @return ClassSchedule
     */
    public function getScheduleById(int $id): ClassSchedule;

    /**
     * Create multiple schedules
     *
     * @param array $data
     * @return Collection
     */
    public function createMultipleSchedules(array $data): Collection;

    /**
     * Get all schedules by class ID
     *
     * @param int $classId
     * @return Collection
     */
    public function getAllSchedulesByClassId(int $classId): Collection;
}
