<?php

namespace App\Http\Controllers;

use App\Models\Tenants\TenantConfig;
use App\Http\Requests\TenantLandingRequest;
use Illuminate\Http\JsonResponse;

class TenantLandingController extends Controller
{
    public function getLandingData(): JsonResponse
    {
        $configs = TenantConfig::where('group', 'landing')
            ->get()
            ->mapWithKeys(function ($config) {
                return [$config->key => $config->value];
            });

        return response()->json([
            'message' => 'Landing data retrieved successfully',
            'data' => $configs
        ]);
    }

    public function getLandingDataByKey(string $key): JsonResponse
    {
        $config = TenantConfig::where('group', 'landing')
            ->where('key', $key)
            ->first();

        if (!$config) {
            return response()->json([
                'message' => 'Landing data not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Landing data retrieved successfully',
            'data' => $config->value
        ]);
    }

    public function setLandingData(TenantLandingRequest $request, string $key): JsonResponse
    {
        $config = TenantConfig::updateOrCreate(
            [
                'key' => $key,
                'group' => 'landing'
            ],
            [
                'value' => $request->value,
                'type' => 'json',
                'description' => 'Tenant landing page configuration data',
                'is_system' => true
            ]
        );

        return response()->json([
            'message' => 'Landing data saved successfully',
            'data' => $config->value
        ]);
    }
}
