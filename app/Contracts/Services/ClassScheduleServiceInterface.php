<?php

namespace App\Contracts\Services;

use App\Models\Tenants\ClassSchedule;
use Illuminate\Database\Eloquent\Collection;

interface ClassScheduleServiceInterface
{
    /**
     * Get class schedules with filters
     *
     * @param array $filters
     * @return Collection
     */
    public function getSchedules(array $filters): Collection;

    /**
     * Get class schedule by ID
     *
     * @param int $id
     * @return ClassSchedule
     */
    public function getScheduleById(int $id): ClassSchedule;
}
