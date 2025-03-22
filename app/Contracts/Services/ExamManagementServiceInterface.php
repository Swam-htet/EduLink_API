<?php

namespace App\Contracts\Services;

use App\Models\Tenants\Exam;
use Illuminate\Pagination\LengthAwarePaginator;

interface ExamManagementServiceInterface
{
    /**
     * Get filtered exams
     *
     * @param array $filters
     * @return LengthAwarePaginator
     */
    public function getFilteredExams(array $filters): LengthAwarePaginator;

    /**
     * Create new exam
     *
     * @param array $data
     * @return Exam
     */
    public function createExam(array $data): Exam;

    /**
     * Find exam by ID
     *
     * @param int $id
     * @return Exam
     */
    public function findExamById(int $id): Exam;

    /**
     * Update exam
     *
     * @param int $id
     * @param array $data
     * @return Exam
     */
    public function updateExam(int $id, array $data): Exam;

    /**
     * Upload questions to an exam section
     *
     * @param int $examId
     * @param array $data
     * @return Exam
     */
    public function uploadQuestions(int $examId, array $data): Exam;
}
