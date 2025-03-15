<?php

namespace App\Contracts\Services;

use Illuminate\Support\Collection;

interface TenantConfigServiceInterface
{
    public function getAllConfigs(): Collection;
    public function getConfigByKey(string $key);
    public function getConfigsByGroup(string $group);
    public function createConfig(array $data);
    public function deleteConfig(string $key);
}
