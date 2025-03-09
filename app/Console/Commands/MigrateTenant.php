<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Services\TenantService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrateTenant extends Command
{
    protected $signature = 'tenant:migrate {domain} {--fresh} {--seed}';
    protected $description = 'Run migrations for a specific tenant';

    protected $tenantService;

    public function __construct(TenantService $tenantService)
    {
        parent::__construct();
        $this->tenantService = $tenantService;
    }

    public function handle()
    {
        $domain = $this->argument('domain');

        // Find the tenant
        $tenant = Tenant::where('domain', $domain)->first();

        if (!$tenant) {
            $this->error("Tenant with domain '{$domain}' not found!");
            return 1;
        }

        $this->info("Processing tenant: {$tenant->name} ({$tenant->domain})");

        try {
            // Configure the tenant connection
            $this->tenantService->setTenant($tenant);

            // Run the migration
            $this->info("Running migrations for tenant database: {$tenant->database_name}");
            $command = $this->option('fresh') ? 'migrate:fresh' : 'migrate';

            $result = Artisan::call($command, [
                '--database' => 'tenant',
                '--path' => 'database/migrations/tenant',
                '--force' => true
            ]);

            if ($this->option('seed')) {
                $this->info("Seeding database for tenant: {$tenant->database_name}");
                Artisan::call('db:seed', [
                    '--database' => 'tenant',
                    '--force' => true
                ]);
            }

            if ($result === 0) {
                $this->info(Artisan::output());
                $this->info("Successfully migrated tenant: {$tenant->name}");
            } else {
                $this->error("Migration failed for tenant: {$tenant->name}");
                $this->error(Artisan::output());
            }
        } catch (\Exception $e) {
            $this->error("Failed to process tenant {$tenant->name}: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
