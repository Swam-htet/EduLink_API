<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Tenants\TenantConfig;

interface TenantConfigRepositoryInterface
{
    public function all(): Collection;
    public function create(array $data): TenantConfig;
    public function delete(string $key): bool;
}
