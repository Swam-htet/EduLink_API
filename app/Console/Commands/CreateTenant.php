<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class CreateTenant extends Command
{
    protected $signature = 'tenant:create {name} {domain} {database?}';
    protected $description = 'Create a new tenant with its database';

    public function handle()
    {
        $name = $this->argument('name');
        $domain = $this->argument('domain');
        $database = $this->argument('database') ?? 'tenant_' . strtolower(str_replace(['.', '-'], '_', $domain));

        if (Tenant::where('domain', $domain)->exists()) {
            $this->error("Tenant with domain '{$domain}' already exists!");
            return 1;
        }

        if (Tenant::where('database_name', $database)->exists()) {
            $this->error("Tenant with database '{$database}' already exists!");
            return 1;
        }

        try {
            $this->info("Creating database '{$database}'...");

            $connection = [
                'driver' => 'mysql',
                'host' => 'db',
                'port' => 3306,
                'database' => 'mysql',
                'username' => 'root',
                'password' => 'root_password',
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
            ];

            Config::set('database.connections.tenant_creator', $connection);
            DB::purge('tenant_creator');

            $db = DB::connection('tenant_creator');
            $db->statement("CREATE DATABASE IF NOT EXISTS `{$database}`");
            $db->statement("GRANT ALL PRIVILEGES ON `{$database}`.* TO 'edu_link_admin'@'%'");
            $db->statement("FLUSH PRIVILEGES");

            DB::purge('tenant_creator');

        } catch (\Exception $e) {
            $this->error("Failed to create database: " . $e->getMessage());
            return 1;
        }

        $tenant = Tenant::create([
            'name' => $name,
            'domain' => $domain,
            'database_name' => $database,
            'is_active' => true,
        ]);

        $this->info("Tenant '{$name}' created successfully!");

        // Configure tenant connection for migrations
        $config = [
            'driver' => 'mysql',
            'host' => 'db',
            'port' => 3306,
            'database' => $database,
            'username' => 'edu_link_admin',
            'password' => 'edu_link_admin',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
        ];

        Config::set('database.connections.tenant', $config);
        DB::purge('tenant');

        $this->info("Running migrations for tenant database...");
        try {
            Artisan::call('migrate', [
                '--database' => 'tenant',
                '--path' => 'database/migrations/tenant',
                '--force' => true,
            ]);
            $this->info("Migrations completed successfully!");
        } catch (\Exception $e) {
            $this->error("Failed to run migrations: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
