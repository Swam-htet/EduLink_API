<?php

namespace App\Http\Controllers;

use App\Contracts\Services\TenantConfigServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\TenantConfig\{
    StoreTenantConfigRequest,
};
use App\Http\Resources\TenantConfig\{TenantConfigCollection, TenantConfigResource};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TenantConfigController extends Controller
{
    public function __construct(
        protected TenantConfigServiceInterface $configService
    ) {}

    public function index(): JsonResponse
    {
        $configs = $this->configService->getAllConfigs();
        return response()->json([
            'success' => true,
            'data' => new TenantConfigCollection($configs)
        ]);
    }

    public function store(StoreTenantConfigRequest $request): JsonResponse
    {
        $config = $this->configService->createConfig($request->validated());

        return response()->json([
            'success' => true,
            'data' => new TenantConfigResource($config),
            'message' => "Configuration created successfully"
        ], Response::HTTP_CREATED);
    }

    public function destroy(string $key): JsonResponse
    {
        $this->configService->deleteConfig($key);
        return response()->json([
            'success' => true,
            'message' => "Configuration deleted successfully"
        ]);
    }
}
