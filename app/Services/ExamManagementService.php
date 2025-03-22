<?php

namespace App\Services;

use App\Contracts\Services\ExamManagementServiceInterface;
use App\Contracts\Repositories\ExamRepositoryInterface;
use App\Models\Tenants\Exam;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ExamManagementService implements ExamManagementServiceInterface
{
    protected $examRepository;

    public function __construct(ExamRepositoryInterface $examRepository)
    {
        $this->examRepository = $examRepository;
    }

    public function getFilteredExams(array $filters): LengthAwarePaginator
    {
        return $this->examRepository->getPaginatedExams($filters);
    }

    public function createExam(array $data): Exam
    {
        try {
            DB::beginTransaction();

            // Create exam
            $exam = $this->examRepository->create($data);

            // Create sections if provided
            if (isset($data['sections'])) {
                foreach ($data['sections'] as $section) {
                    $exam->sections()->create($section);
                }
            }

            DB::commit();
            return $exam->load('sections');

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function findExamById(int $id): Exam
    {
        $exam = $this->examRepository->findById($id);

        return $exam->load(['class', 'subject', 'sections']);
    }

    public function updateExam(int $id, array $data): Exam
    {
        try {
            DB::beginTransaction();

            $exam = $this->examRepository->update($id, $data);

            if (isset($data['sections'])) {
                foreach ($data['sections'] as $section) {
                    $exam->sections()->updateOrCreate(['section_number' => $section['section_number']], $section);
                }
            }

            DB::commit();
            return $exam->load(['class', 'subject', 'sections']);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function uploadQuestions(int $examId, array $data): Exam
    {
        try {
            DB::beginTransaction();

            $exam = $this->examRepository->findById($examId);

            // Check if exam is in draft status
            if ($exam->status !== 'draft') {
                throw ValidationException::withMessages([
                    'status' => 'Questions can only be uploaded to draft exams'
                ]);
            }

            // Process each question
            foreach ($data['exam_questions'] as $questionData) {
                // Verify section belongs to exam
                $section = $exam->sections()->find($questionData['section_id']);
                if (!$section) {
                    throw ValidationException::withMessages([
                        'section_id' => 'Section does not belong to this exam'
                    ]);
                }

                $this->createQuestion($exam, $section, $questionData);
            }

            // Update section totals for all modified sections
            $sectionIds = array_unique(array_column($data['exam_questions'], 'section_id'));
            foreach ($sectionIds as $sectionId) {
                $section = $exam->sections()->find($sectionId);
                $this->updateSectionTotals($section);
            }

            DB::commit();
            return $exam->load(['sections.questions']);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Create a single question
     */
    protected function createQuestion($exam, $section, array $data): void
    {
        // Prepare question data based on type
        $questionData = [
            'exam_id' => $exam->id,
            'section_id' => $section->id,
            'question' => $data['question'],
            'type' => $data['type'],
            'marks' => $data['marks'],
            'explanation' => $data['explanation'] ?? null,
            'answer_guidelines' => $data['answer_guidelines'] ?? null,
            'requires_manual_grading' => $data['requires_manual_grading'] ?? false,
            'difficulty_level' => $data['difficulty_level'],
            'time_limit' => $data['time_limit'] ?? null,
        ];

        // Add type-specific data
        switch ($data['type']) {
            case 'multiple_choice':
            case 'true_false':
                $questionData['options'] = $data['options'];
                $questionData['correct_answer'] = $data['correct_answer'];
                break;

            case 'fill_in_blank':
                $questionData['blank_answers'] = $data['blank_answers'];
                break;

            case 'matching':
                $questionData['matching_pairs'] = $data['matching_pairs'];
                break;

            case 'ordering':
                $questionData['options'] = $data['options'];
                $questionData['correct_order'] = $data['correct_order'];
                break;

            case 'short_answer':
            case 'long_answer':
            case 'essay':
                $questionData['requires_manual_grading'] = true;
                break;
        }

        $section->questions()->create($questionData);
    }

    /**
     * Update section totals
     */
    protected function updateSectionTotals($section): void
    {
        $totalQuestions = $section->questions()->count();
        $totalMarks = $section->questions()->sum('marks');

        $section->update([
            'total_questions' => $totalQuestions,
            'total_marks' => $totalMarks
        ]);
    }
}
