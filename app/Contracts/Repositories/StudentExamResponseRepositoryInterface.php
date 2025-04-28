<?php

namespace App\Contracts\Repositories;

use App\Models\Tenants\StudentExamResponse;
use Illuminate\Support\Collection;
interface StudentExamResponseRepositoryInterface
{
    public function create(array $data): StudentExamResponse;

    public function getAnswersByQuestionIdsAndStudentId(array $question_ids, int $studentId): Collection;

    public function update(int $answerId, int $marks, string $comments): bool;
}
