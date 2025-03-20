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
    public function getAllSchedules(): Collection;

    /**
     * Get schedule by ID
     *
     * @param int $id
     * @return ClassSchedule
     */
    public function getScheduleById(int $id): ClassSchedule;

    /**
     * Create new schedule
     *
     * @param array $data
     * @return ClassSchedule
     */
    public function createSchedule(array $data): ClassSchedule;
}
