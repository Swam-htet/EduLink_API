<?php

namespace App\Http\Controllers;

use App\Http\Requests\Class\CreateClassRequest;
use App\Http\Requests\Class\UpdateClassRequest;
use App\Http\Requests\Class\FindClassByIdRequest;
use App\Contracts\Services\ClassManagementServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ClassManagementController extends Controller
{
    protected $classService;

    public function __construct(ClassManagementServiceInterface $classService)
    {
        $this->classService = $classService;
    }

    public function index(): JsonResponse
    {
        $classes = $this->classService->getAllClasses();

        return response()->json([
            'data' => $classes
        ]);
    }

    public function show(FindClassByIdRequest $request): JsonResponse
    {
        $class = $this->classService->getClassById($request->id);

        return response()->json([
            'data' => $class
        ]);
    }

    public function store(CreateClassRequest $request): JsonResponse
    {
        $class = $this->classService->createClass($request->validated());

        return response()->json([
            'message' => 'Class created successfully.',
            'data' => $class
        ], Response::HTTP_CREATED);
    }

    public function update(UpdateClassRequest $request): JsonResponse
    {
        $class = $this->classService->updateClass(
            $request->id,
            $request->validated()
        );

        return response()->json([
            'message' => 'Class updated successfully.',
            'data' => $class
        ]);
    }
}
