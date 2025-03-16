<?php

namespace App\Services;

use App\Contracts\Services\TenantConfigServiceInterface;
use App\Contracts\Repositories\TenantConfigRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Tenants\TenantConfig;

class TenantConfigService implements TenantConfigServiceInterface
{

    public function __construct(protected TenantConfigRepositoryInterface $repository)
    {
    }

    public function getAllConfigs(): Collection
    {
        return collect($this->repository->all()->map(function ($config) {
            return [
                'key' => $config->key,
                'value' => $config->typed_value,
                'type' => $config->type,
                'group' => $config->group,
                'description' => $config->description,
                'is_system' => $config->is_system,
            ];
        }));
    }

    public function createConfig(array $data): TenantConfig
    {
        $config = $this->repository->create($data);
        return $config;
    }

    public function deleteConfig(string $key): bool
    {
        return $this->repository->delete($key);
    }
}
