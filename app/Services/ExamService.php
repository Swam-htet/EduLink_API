<?php

namespace App\Services;

use App\Contracts\Services\ExamServiceInterface;
use App\Contracts\Repositories\ExamRepositoryInterface;
use App\Contracts\Repositories\StudentExamResponseRepositoryInterface;
use App\Contracts\Repositories\ExamResultRepositoryInterface;
use App\Models\Tenants\Exam;
use App\Models\Tenants\StudentExamResponse;
use App\Models\Tenants\Student;
use App\Models\Tenants\ExamResult;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use App\Mail\ExamResultMail;
use Illuminate\Support\Facades\Mail;

class ExamService implements ExamServiceInterface
{
    protected $examRepository;
    protected $studentExamResponseRepository;
    protected $examResultRepository;

    public function __construct(ExamRepositoryInterface $examRepository,StudentExamResponseRepositoryInterface $studentExamResponseRepository, ExamResultRepositoryInterface $examResultRepository)
    {
        $this->examRepository = $examRepository;
        $this->studentExamResponseRepository = $studentExamResponseRepository;
        $this->examResultRepository = $examResultRepository;
    }

    public function getFilteredExams(array $filters): LengthAwarePaginator
    {
        return $this->examRepository->getPaginatedExams($filters);
    }

    public function createExam(array $data): Exam
    {
        try {
            DB::beginTransaction();

            $data['end_time'] = Carbon::parse($data['start_time'])->addMinutes((int) $data['duration']);

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

                $this->createQuestion($section, $questionData);
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
    protected function createQuestion($section, array $data): void
    {
        // Prepare question data based on type
        $questionData = [
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

    public function publishExam(int $id): void
    {
        try{
            DB::beginTransaction();
            $exam = $this->examRepository->findById($id);
            $exam->status = 'published';

            $this->sentPublishedExamMailToStudents($exam);
            $exam->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function sentPublishedExamMailToStudents(Exam $exam): void
    {
        $students = $exam->class->students;

        // todo : sent mail to students
        foreach ($students as $student) {
            // Mail::to($student->email)->send(new ExamPublished($exam));
        }
    }

    public function sentManualPublishedExamMailToStudents(int $id): void
    {
       $exam = $this->examRepository->findById($id);
       $this->sentPublishedExamMailToStudents($exam);
    }

    public function getPublishedExamsForStudent(array $filters): LengthAwarePaginator
    {
        return $this->examRepository->getFilteredExamsForStudent($filters);
    }

    public function getPublishedExams(array $filters): LengthAwarePaginator
    {
        $filters['status'] = 'published';
        return $this->getFilteredExams($filters);
    }

    public function getPublishedExamById(int $id, Student $student): Exam
    {
        $student_id = $student->id;
        $examResult = $this->examResultRepository->getExamResultByStudentIdAndExamId($student_id, $id);

        if ($examResult) {
            throw ValidationException::withMessages([
                'message' => 'You have already submitted the exam'
            ]);
        }

        $exam = $this->examRepository->getPublishedExamById($id);
        $examStartDateTime = Carbon::parse($exam->date . ' ' . $exam->start_time);
        $examEndDateTime = Carbon::parse($exam->date . ' ' . $exam->end_time);


        // if ($examStartDateTime > now() || $examEndDateTime < now()) {
        //     throw ValidationException::withMessages([
        //         'message' => 'Cannot access exam data before exam start time or after exam end time'
        //     ]);
        // }

        return $exam;
    }

    public function submitExam(int $id, array $data, Student $student): ExamResult
    {
        try{
            DB::beginTransaction();

            $exam = $this->examRepository->findById($id)->load(['sections.questions']);

            if ($exam->status !== 'published') {
                throw ValidationException::withMessages([
                    'message' => 'Exam is not published'
                ]);
            }

            $answers = $data['answers'];

            if ($exam->status !== 'published') {
                throw ValidationException::withMessages([
                    'message' => 'Exam is not published'
                ]);
            }

            $examStartDateTime = Carbon::parse($exam->date . ' ' . $exam->start_time);
            $examEndDateTime = Carbon::parse($exam->date . ' ' . $exam->end_time);


            // if ($examStartDateTime > now() || $examEndDateTime < now()) {
            //     throw ValidationException::withMessages([
            //         'message' => 'Cannot submit exam before exam start time or after exam end time'
            //     ]);
            // }

            $studentResponses = collect([]);

            foreach ($answers as $answer) {
                $studentResponses[] = $this->calculateStudentResponseFromAnswer($exam, $student, $answer);
            }

            // calculate exam result
            $total_marks_obtained = $studentResponses->sum('marks_obtained');
            $total_questions = $exam->sections->sum('total_questions');
            $correct_answers = $studentResponses->where('is_correct', true)->count();
            $wrong_answers = $studentResponses->where('is_correct', false)->count();
            $condition = 'auto-generated';

            $examResult = $this->examResultRepository->create([
                'exam_id' => $exam->id,
                'student_id' => $student->id,
                'total_marks_obtained' => $total_marks_obtained,
                'total_questions' => $total_questions,
                'correct_answers' => $correct_answers,
                'wrong_answers' => $wrong_answers,
                'condition' => $condition,
                'status' => $total_marks_obtained >= $exam->pass_marks ? 'pass' : 'fail'
            ]);

            DB::commit();
            return $examResult;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function calculateStudentResponseFromAnswer(Exam $exam, Student $student, array $answer): StudentExamResponse
    {
        try{
            DB::beginTransaction();
            $section_id = $answer['section_id'];
            $question_id = $answer['question_id'];
            $student_id = $student->id;
            $question_type = $answer['type'];

            $student_response_data = [
                'student_id' => $student_id,
                'question_id' => $question_id,
            ];

            // check the answer is empty
            if ($answer['answer'] === null) {
                $student_response_data['marks_obtained'] = 0;
                $student_response_data['is_correct'] = false;
                $student_response_data['selected_choice'] = null;
                $student_response_data['fill_in_blank_answers'] = null;
                $student_response_data['ordering_answer'] = null;
                $student_response_data['written_answer'] = null;
                $student_response_data['matching_answers'] = null;
            }

            else{
                $question = $exam->sections->firstWhere('id', $section_id)->questions->firstWhere('id', $question_id);
                $is_correct = false;
                $marks_obtained = 0;

                switch ($question_type) {
                    case 'multiple_choice':
                        $student_response_data['selected_choice'] = $answer['answer']['multiple_choice'];
                        $is_correct = $question->correct_answer === $answer['answer']['multiple_choice'];
                        break;
                    case 'true_false':
                        $student_response_data['selected_choice'] = $answer['answer']['true_false'];
                        $is_correct = $question->correct_answer === $answer['answer']['true_false'];
                        break;
                    case 'fill_in_blank':
                        $student_response_data['fill_in_blank_answers'] = $answer['answer']['fill_in_blank'];
                        // Check if any of the acceptable answers match (case insensitive if specified)
                        $is_correct = true;
                        foreach ($question->blank_answers as $index => $blank) {
                            $student_answer = $answer['answer']['fill_in_blank'][$index] ?? '';
                            $acceptable_answers = collect($blank['acceptable_answers']);

                            if ($blank['case_sensitive']) {
                                $matches = $acceptable_answers->contains($student_answer);
                            } else {
                                $matches = $acceptable_answers->contains(fn($acceptable) =>
                                    strtolower($acceptable) === strtolower($student_answer)
                                );
                            }

                            if (!$matches) {
                                $is_correct = false;
                                break;
                            }
                        }
                        break;
                    case 'short_answer':
                        $student_response_data['written_answer'] = $answer['answer']['short_answer'];
                        break;
                    case 'long_answer':
                        $student_response_data['written_answer'] = $answer['answer']['long_answer'];
                        break;
                    case 'matching':
                        $student_response_data['matching_answers'] = $answer['answer']['matching'];
                        // Check if student's pairs match the correct pairs
                        $correct_pairs = collect($question->matching_pairs['correct_pairs']);
                        $student_pairs = collect($answer['answer']['matching']);

                        $is_correct = true;
                        foreach ($student_pairs as $pair) {
                            $question_id = $pair['question'];
                            $answer_id = $pair['answer'];

                            if ($correct_pairs[$question_id] !== $answer_id) {
                                $is_correct = false;
                                break;
                            }
                        }
                        break;
                    case 'ordering':
                        $student_order = $answer['answer']['ordering'];
                        $student_response_data['ordering_answer'] = $student_order;
                        // Check if the order matches exactly with the correct order
                        $is_correct = $question->correct_order === $student_order;
                        break;
                    case 'essay':
                        $student_response_data['written_answer'] = $answer['answer']['essay'];
                        break;
                }

                $student_response_data['is_correct'] = $is_correct;
                $student_response_data['marks_obtained'] = $is_correct ? $question->marks : 0;
            }

            $student_response = $this->studentExamResponseRepository->create($student_response_data);
            DB::commit();
            return $student_response;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getExamResultsByExamId(int $id): Collection
    {
        return $this->examResultRepository->getExamResultsByExamId($id);
    }

    public function getExamResultByExamIdAndStudentId(int $examId, int $studentId): ExamResult
    {
        return $this->examResultRepository->getExamResultByExamIdAndStudentId($examId, $studentId);
    }

    public function getExamResult(int $result_id): ExamResult
    {
        return $this->examResultRepository->getExamResultByResultId($result_id);
    }

    public function getAnswersByExamIdAndStudentId(int $examId, int $studentId): Collection
    {
        // get questions list by exam -> by exam's section ids
        $questions = $this->examRepository->findById($examId)->sections->pluck('questions');
        $question_ids = $questions->flatten()->pluck('id')->toArray();
        $student_responses = $this->studentExamResponseRepository->getAnswersByQuestionIdsAndStudentId($question_ids, $studentId);
        return $student_responses;
    }

    public function updateExamResponse(int $answerId, int $resultId, int $marks, string $comments): bool
    {
        $this->studentExamResponseRepository->update($answerId, $marks, $comments);
        $this->examResultRepository->update($resultId, $marks);
        return true;
    }

    public function sendExamResultsToStudents(int $examId): bool
    {
        $exam = $this->examRepository->findById($examId);
        $students = $exam->class->students;

        foreach ($students as $student) {
            $examResult = $this->examResultRepository->getExamResultByStudentIdAndExamId($student->id, $examId);
            $this->sentExamResultMailToStudent($student, $examResult);
        }

        return true;
    }

    private function sentExamResultMailToStudent(Student $student, $examResult): void
    {
        if ($student->email && $examResult) {
            Mail::to($student->email)->send(new ExamResultMail(
                [
                    'student_name' => $student->first_name . ' ' . $student->last_name,
                    'exam_title' => $examResult->exam->title,
                    'total_marks_obtained' => $examResult->total_marks_obtained,
                    'total_questions' => $examResult->total_questions,
                    'correct_answers' => $examResult->correct_answers,
                    'wrong_answers' => $examResult->wrong_answers,
                    'status' => $examResult->status,
                    'exam_result_id' => $examResult->id,
                ]
            ));
        }
    }
}
