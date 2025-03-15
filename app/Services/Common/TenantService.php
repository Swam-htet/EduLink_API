<?php

namespace App\Services\Common;

use App\Models\Tenant;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Contracts\Services\Common\TenantServiceInterface;


class TenantService implements TenantServiceInterface
{
    protected ?Tenant $tenant = null;

    public function getTenant(): ?Tenant
    {
        return $this->tenant;
    }

    public function setTenant(Tenant $tenant): void
    {
        $this->tenant = $tenant;
        $this->configureTenantConnection();
    }

    public function identifyTenantByDomain(string $domain): ?Tenant
    {
        $tenant = Tenant::where('domain', $domain)
            ->where('is_active', true)
            ->first();

        if ($tenant) {
            $this->setTenant($tenant);
        }

        return $tenant;
    }

    protected function configureTenantConnection(): void
    {
        if (!$this->tenant) {
            return;
        }

        // Create a new connection configuration based on tenant environment variables
        $config = [
            'driver' => 'mysql',
            'host' => 'db', // Docker service name from docker-compose.yml
            'port' => 3306,
            'database' => $this->tenant->database_name,
            'username' => 'edu_link_admin',
            'password' => 'edu_link_admin',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ];

        // Set the tenant connection configuration
        Config::set('database.connections.tenant', $config);

        // Purge the existing connection if it exists
        DB::purge('tenant');
    }

    public function resetConnection(): void
    {
        DB::purge('tenant');
        Config::set('database.default', env('DB_CONNECTION', 'mysql'));
    }
}
