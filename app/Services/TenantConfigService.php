<?php

namespace App\Services;

use App\Repositories\TenantConfigRepository;
use App\Contracts\Services\TenantConfigServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class TenantConfigService implements TenantConfigServiceInterface
{

    public function __construct(protected TenantConfigRepository $repository)
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

    public function getConfigByKey(string $key)
    {
        $config = $this->repository->getByKey($key);
        return $config ? $config->typed_value : null;
    }

    public function getConfigsByGroup(string $group): Collection
    {
        return collect($this->repository->getByGroup($group)->map(function ($config) {
            return [
                'key' => $config->key,
                'value' => $config->typed_value,
                'type' => $config->type,
                'description' => $config->description,
            ];
        }));
    }

    public function createConfig(array $data)
    {
        $config = $this->repository->create($data);
        return $config;
    }

    public function deleteConfig(string $key)
    {
        $config = $this->repository->getByKey($key);
        if ($config && $config->is_system) {
            throw ValidationException::withMessages([
                'key' => ['Cannot delete system configuration'],
            ]);
        }
        $success = $this->repository->delete($key);
        return $success;
    }
}
