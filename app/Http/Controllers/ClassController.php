<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ClassServiceInterface;
use App\Http\Requests\Class\FindClassByIdRequest;
use App\Http\Requests\Class\ListClassRequest;
use App\Http\Resources\ClassResource;
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
    // todo : need to create filter request
    public function index(ListClassRequest $request): JsonResponse
    {
        $value = $this->classService->getAllClasses($request->filters());

        return response()->json([
            'data' => ClassResource::collection($value->items()),
            'meta' => [
                'total' => $value->total(),
                'per_page' => $value->perPage(),
                'current_page' => $value->currentPage(),
                'last_page' => $value->lastPage(),
            ]
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
            'data' => new ClassResource($class)
        ]);
    }
}
