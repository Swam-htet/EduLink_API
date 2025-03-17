<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ClassServiceInterface;
use App\Http\Requests\Class\FindClassByIdRequest;
use Illuminate\Http\JsonResponse;

class ClassController extends Controller
{
    protected $classService;

    public function __construct(ClassServiceInterface $classService)
    {
        $this->classService = $classService;
    }

    /**
     * Get all active classes
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $classes = $this->classService->getAllClasses();

        return response()->json([
            'data' => $classes
        ]);
    }

    /**
     * Get active class by ID
     *
     * @param FindClassByIdRequest $request
     * @return JsonResponse
     */
    public function show(FindClassByIdRequest $request): JsonResponse
    {
        $class = $this->classService->getClassById($request->id);

        return response()->json([
            'data' => $class
        ]);
    }
}
