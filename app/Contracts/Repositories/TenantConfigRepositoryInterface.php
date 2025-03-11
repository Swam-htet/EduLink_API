<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Tenants\TenantConfig;

interface TenantConfigRepositoryInterface
{
    public function all(): Collection;
    public function getByKey(string $key);
    public function getByGroup(string $group): Collection;
    public function create(array $data): TenantConfig;
    public function update(string $key, array $data): bool;
    public function delete(string $key): bool;
    public function getSystemConfigs(): Collection;
    public function bulkUpdate(array $configs): bool;
}
