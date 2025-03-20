<?php

namespace App\Services;

use App\Contracts\Services\ClassScheduleServiceInterface;
use App\Models\Tenants\ClassSchedule;
use Illuminate\Database\Eloquent\Collection;

class ClassScheduleService implements ClassScheduleServiceInterface
{
    /**
     * Get paginated class schedules with filters
     *
     * @param array $filters
     * @return Collection
     */
    public function getSchedules(array $filters): Collection
    {
        $query = ClassSchedule::with(['class', 'staff']);

        // Filter by student ID
        if (isset($filters['student_id'])) {
            $query->whereHas('class.enrollments', function ($query) use ($filters) {
                $query->where('student_id', $filters['student_id'])
                    ->where('status', 'enrolled');
            });
        }

        // Filter by class ID
        if (isset($filters['class_id'])) {
            $query->where('class_id', $filters['class_id']);
        }

        // Filter by status
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by specific date
        if (isset($filters['date'])) {
            $query->whereDate('date', $filters['date']);
        }

        // Filter by date range
        if (isset($filters['date_range'])) {
            $query->whereBetween('date', [
                $filters['date_range']['start'],
                $filters['date_range']['end']
            ]);
        }

        return $query->latest('date')->get();
    }

    /**
     * Get class schedule by ID
     *
     * @param int $id
     * @param int|null $studentId
     * @return ClassSchedule
     */
    public function getScheduleById(int $id, ?int $studentId = null): ClassSchedule
    {
        $query = ClassSchedule::with(['class', 'staff']);

        if ($studentId) {
            $query->with(['attendances' => function ($query) use ($studentId) {
                $query->where('student_id', $studentId);
            }]);
        }

        return $query->findOrFail($id);
    }
}
