<?php

namespace App\Services;

use App\Repositories\TenantConfigRepository;
use App\Contracts\Services\TenantConfigServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TenantConfigService implements TenantConfigServiceInterface
{
    protected $repository;
    protected $cachePrefix = 'tenant_config:';
    protected $cacheTTL = 3600; // 1 hour

    public function __construct(TenantConfigRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllConfigs(): Collection
    {
        return Cache::remember($this->cachePrefix . 'all', $this->cacheTTL, function () {
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
        });
    }

    public function getConfigByKey(string $key)
    {
        return Cache::remember($this->cachePrefix . $key, $this->cacheTTL, function () use ($key) {
            $config = $this->repository->getByKey($key);
            return $config ? $config->typed_value : null;
        });
    }

    public function getConfigsByGroup(string $group): Collection
    {
        return Cache::remember($this->cachePrefix . "group:{$group}", $this->cacheTTL, function () use ($group) {
            return collect($this->repository->getByGroup($group)->map(function ($config) {
                return [
                    'key' => $config->key,
                    'value' => $config->typed_value,
                    'type' => $config->type,
                    'description' => $config->description,
                ];
            }));
        });
    }

    public function createConfig(array $data)
    {
        $this->validateConfig($data);
        $config = $this->repository->create($data);
        $this->clearCache($config->key, $config->group);
        return $config;
    }

    public function updateConfig(string $key, array $data)
    {
        $this->validateConfig(array_merge(['key' => $key], $data));
        $success = $this->repository->update($key, $data);
        if ($success) {
            $this->clearCache($key, $data['group'] ?? null);
        }
        return $success;
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
        if ($success) {
            $this->clearCache($key, $config?->group);
        }
        return $success;
    }

    public function bulkUpdateConfigs(array $configs)
    {
        foreach ($configs as $key => $value) {
            $this->validateConfig(['key' => $key, 'value' => $value]);
        }
        $success = $this->repository->bulkUpdate($configs);
        if ($success) {
            Cache::tags([$this->cachePrefix])->flush();
        }
        return $success;
    }

    protected function validateConfig(array $data)
    {
        $validator = Validator::make($data, [
            'key' => 'required|string|max:255',
            'value' => 'required',
            'type' => 'sometimes|required|in:string,boolean,integer,json',
            'group' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_system' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            throw ValidationException::withMessages($validator->errors()->toArray());
        }
    }

    protected function clearCache(string $key, ?string $group = null)
    {
        Cache::forget($this->cachePrefix . 'all');
        Cache::forget($this->cachePrefix . $key);
        if ($group) {
            Cache::forget($this->cachePrefix . "group:{$group}");
        }
    }
}
