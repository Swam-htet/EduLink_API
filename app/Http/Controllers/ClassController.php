<?php

namespace App\Http\Controllers;

use App\Contracts\Services\ClassServiceInterface;
use App\Http\Resources\ClassResource;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
class ClassController extends Controller
{
    protected $classService;

    public function __construct(ClassServiceInterface $classService)
    {
        $this->classService = $classService;
    }


    public function index(Request $request): JsonResponse
    {
        $classes = $request->user()->classes;
        return response()->json([
            'data' => ClassResource::collection($classes),
            'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
