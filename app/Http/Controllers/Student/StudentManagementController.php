<?php

namespace App\Http\Controllers\Student;

use App\Contracts\Services\StudentManagementServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class StudentManagementController extends Controller
{
    protected $studentManagementService;

    public function __construct(StudentManagementServiceInterface $studentManagementService)
    {
        $this->studentManagementService = $studentManagementService;
    }

    public function index(): JsonResponse
    {
        $students = $this->studentManagementService->getAllStudents();

        return response()->json([
            'success' => true,
            'data' => [
                'students' => $students
            ]
        ]);
    }

    public function show(string $id): JsonResponse
    {
        $student = $this->studentManagementService->getStudentById($id);

        return response()->json([
            'success' => true,
            'data' => [
                'student' => $student
            ]
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $validatedData = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'phone_number' => 'sometimes|string|max:20|regex:/^09\d{8}$/',
            'date_of_birth' => 'sometimes|date|before:today',
            'gender' => 'sometimes|in:male,female,other',
            'address' => 'sometimes|string|max:500',
            'parent_name' => 'sometimes|string|max:255',
            'parent_phone' => 'sometimes|string|max:20|regex:/^09\d{8}$/',
            'parent_email' => 'sometimes|email|max:255',
            'parent_occupation' => 'sometimes|string|max:255',
            'parent_address' => 'sometimes|string|max:500',
            'emergency_contact_name' => 'sometimes|string|max:255',
            'emergency_contact_phone' => 'sometimes|string|max:20|regex:/^09\d{8}$/',
            'is_active' => 'sometimes|boolean',
        ]);

        $student = $this->studentManagementService->updateStudent($id, $validatedData);

        return response()->json([
            'success' => true,
            'message' => trans('messages.success.student_updated'),
            'data' => [
                'student' => $student
            ]
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->studentManagementService->deleteStudent($id);

        return response()->json([
            'success' => true,
            'message' => trans('messages.success.student_deleted')
        ]);
    }
}
