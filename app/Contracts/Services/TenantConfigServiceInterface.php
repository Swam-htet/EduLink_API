<?php

namespace App\Contracts\Services;

use Illuminate\Support\Collection;
use App\Models\Tenants\TenantConfig;

interface TenantConfigServiceInterface
{
    public function getAllConfigs(): Collection;
    public function createConfig(array $data): TenantConfig;
    public function deleteConfig(string $key): bool;
}
