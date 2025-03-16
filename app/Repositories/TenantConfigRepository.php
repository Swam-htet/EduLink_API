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

    public function create(array $data): TenantConfig
    {
        return $this->model->create($data);
    }

    public function delete(string $key): bool
    {
        return $this->model->where('key', $key)->delete();
    }
}
