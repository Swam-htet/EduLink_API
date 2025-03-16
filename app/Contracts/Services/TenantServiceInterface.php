<?php

namespace App\Contracts\Services;

use App\Models\Tenant;

interface TenantServiceInterface
{
    public function getTenant(): ?Tenant;
    public function setTenant(Tenant $tenant): void;
    public function identifyTenantByDomain(string $domain): ?Tenant;
    public function resetConnection(): void;
}
