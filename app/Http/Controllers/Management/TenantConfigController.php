<?php

namespace App\Http\Controllers\Management;

use App\Contracts\Services\TenantConfigServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\TenantConfig\{
    StoreTenantConfigRequest,
    UpdateTenantConfigRequest,
    BulkUpdateTenantConfigRequest
};
use App\Http\Resources\TenantConfig\{TenantConfigCollection, TenantConfigResource};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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

    public function show(string $key): JsonResponse
    {
        $config = $this->configService->getConfigByKey($key);

        if (!$config) {
            throw new NotFoundHttpException(trans('messages.error.resource_not_found'));
        }

        return response()->json([
            'success' => true,
            'data' => new TenantConfigResource($config)
        ]);
    }

    public function getByGroup(string $group): JsonResponse
    {
        $configs = $this->configService->getConfigsByGroup($group);
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
            'message' => trans('messages.success.config_created')
        ], Response::HTTP_CREATED);
    }

    public function update(UpdateTenantConfigRequest $request, string $key): JsonResponse
    {
        $this->configService->updateConfig($key, $request->validated());
        return response()->json([
            'success' => true,
            'message' => trans('messages.success.config_updated')
        ]);
    }

    public function destroy(string $key): JsonResponse
    {
        $this->configService->deleteConfig($key);
        return response()->json([
            'success' => true,
            'message' => trans('messages.success.config_deleted')
        ]);
    }

    public function bulkUpdate(BulkUpdateTenantConfigRequest $request): JsonResponse
    {
        $this->configService->bulkUpdateConfigs($request->validated());
        return response()->json([
            'success' => true,
            'message' => trans('messages.success.configs_updated')
        ]);
    }
}
