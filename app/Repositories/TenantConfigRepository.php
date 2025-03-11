<?php

namespace App\Repositories;

use App\Models\Tenants\TenantConfig;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\Repositories\TenantConfigRepositoryInterface;

class TenantConfigRepository implements TenantConfigRepositoryInterface
{
    protected $model;

    public function __construct(TenantConfig $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function getByKey(string $key)
    {
        return $this->model->where('key', $key)->first();
    }

    public function getByGroup(string $group): Collection
    {
        return $this->model->where('group', $group)->get();
    }

    public function create(array $data): TenantConfig
    {
        return $this->model->create($data);
    }

    public function update(string $key, array $data): bool
    {
        return $this->model->where('key', $key)->update($data);
    }

    public function delete(string $key): bool
    {
        return $this->model->where('key', $key)->delete();
    }

    public function getSystemConfigs(): Collection
    {
        return $this->model->where('is_system', true)->get();
    }

    public function bulkUpdate(array $configs): bool
    {
        foreach ($configs as $key => $value) {
            $this->model->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
        return true;
    }
}
