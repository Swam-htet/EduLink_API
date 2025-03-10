<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Services\TenantConfigService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TenantConfigController extends Controller
{
    protected $configService;

    public function __construct(TenantConfigService $configService)
    {
        $this->configService = $configService;
    }

    public function index(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->configService->getAllConfigs()
        ]);
    }

    public function show(string $key): JsonResponse
    {
        $config = $this->configService->getConfigByKey($key);

        if ($config === null) {
            return response()->json([
                'success' => false,
                'message' => 'Configuration not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $config
        ]);
    }

    public function getByGroup(string $group): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->configService->getConfigsByGroup($group)
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $config = $this->configService->createConfig($request->all());
            return response()->json([
                'success' => true,
                'data' => $config,
                'message' => 'Configuration created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function update(Request $request, string $key): JsonResponse
    {
        try {
            $success = $this->configService->updateConfig($key, $request->all());
            return response()->json([
                'success' => $success,
                'message' => $success ? 'Configuration updated successfully' : 'Configuration not found'
            ], $success ? 200 : 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function destroy(string $key): JsonResponse
    {
        try {
            $success = $this->configService->deleteConfig($key);
            return response()->json([
                'success' => $success,
                'message' => $success ? 'Configuration deleted successfully' : 'Configuration not found'
            ], $success ? 200 : 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function bulkUpdate(Request $request): JsonResponse
    {
        try {
            $success = $this->configService->bulkUpdateConfigs($request->all());
            return response()->json([
                'success' => $success,
                'message' => 'Configurations updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}
