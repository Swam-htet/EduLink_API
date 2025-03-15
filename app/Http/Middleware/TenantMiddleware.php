<?php

namespace App\Http\Middleware;

use App\Contracts\Services\Common\TenantServiceInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TenantMiddleware
{
    protected $tenantService;

    public function __construct(TenantServiceInterface $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        // Get tenant identifier from header
        $tenantId = $request->header('X-Tenant');

        if (!$tenantId) {
            return response()->json([
                'message' => __('messages.error.tenant_not_found'),
                'error' => 'X-Tenant header is required'
            ], Response::HTTP_BAD_REQUEST);
        }

        // Identify tenant by domain (which is now stored in X-Tenant header)
        $tenant = $this->tenantService->identifyTenantByDomain($tenantId);

        if (!$tenant) {
            return response()->json([
                'message' => __('messages.error.tenant_not_found'),
                'error' => 'Invalid tenant identifier'
            ], Response::HTTP_NOT_FOUND);
        }

        // inject tenant info to request
        $request->attributes->set('tenant', $tenant);

        return $next($request);
    }
}
