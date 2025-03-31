<?php

namespace App\Http\Controllers;

use App\Http\Requests\Class\CreateClassRequest;
use App\Http\Requests\Class\UpdateClassRequest;
use App\Http\Requests\Class\FindClassByIdRequest;
use App\Contracts\Services\ClassManagementServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use App\Http\Requests\Class\ListClassRequest;
use App\Http\Resources\Management\ManagementClassResource;
use Carbon\Carbon;
class ClassManagementController extends Controller
{
    protected $classService;

    public function __construct(ClassManagementServiceInterface $classService)
    {
        $this->classService = $classService;
    }

    /**
     * Get all classes
     * @param ListClassRequest $request
     * @return JsonResponse
     */
    public function index(ListClassRequest $request): JsonResponse
    {
        $value = $this->classService->getAllClasses($request->filters());

        return response()->json([
            'data' => ManagementClassResource::collection($value->items()),
            'meta' => [
                'total' => $value->total(),
                'per_page' => $value->perPage(),
                'current_page' => $value->currentPage(),
                'last_page' => $value->lastPage(),
            ],
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Get all ongoing classes
     * @return JsonResponse
     */
    public function ongoingClasses(): JsonResponse
    {
        $value = $this->classService->getOngoingClasses();

        return response()->json([
            'data' => ManagementClassResource::collection($value),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }


    /**
     * Get class by id
     * @param FindClassByIdRequest $request
     * @return JsonResponse
     */
    public function show(FindClassByIdRequest $request): JsonResponse
    {
        $class = $this->classService->getClassById($request->id);

        return response()->json([
            'data' => new ManagementClassResource($class),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }

    /**
     * Create a new class
     * @param CreateClassRequest $request
     * @return JsonResponse
     */
    public function store(CreateClassRequest $request): JsonResponse
    {
        $class = $this->classService->createClass($request->validated());

        return response()->json([
            'message' => 'Class created successfully.',
            'data' => new ManagementClassResource($class),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ], Response::HTTP_CREATED);
    }

    /**
     * Update a class
     * @param UpdateClassRequest $request
     * @return JsonResponse
     */
    public function update(UpdateClassRequest $request): JsonResponse
    {
        $class = $this->classService->updateClass(
            $request->id,
            $request->validated()
        );

        return response()->json([
            'message' => 'Class updated successfully.',
            'data' => new ManagementClassResource($class),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
