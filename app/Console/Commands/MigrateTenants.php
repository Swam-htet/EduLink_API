<?php

namespace App\Console\Commands;

use App\Models\Tenant;
use App\Services\TenantService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class MigrateTenants extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:migrate {--fresh} {--seed}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run migrations for all tenant databases';

    protected $tenantService;

    public function __construct(TenantService $tenantService)
    {
        parent::__construct();
        $this->tenantService = $tenantService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            $this->info("Processing tenant: {$tenant->name} ({$tenant->domain})");

            try {
                // Create database if it doesn't exist
                $this->createDatabase($tenant->database_name);

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
            }
        }

        return 0;
    }

    protected function createDatabase(string $database): void
    {
        $this->info("Ensuring database exists: {$database}");

        $connection = [
            'driver' => 'mysql',
            'host' => 'db',
            'port' => 3306,
            'database' => 'mysql',
            'username' => 'edu_link_admin',
            'password' => 'edu_link_admin',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ];

        config(['database.connections.mysql' => $connection]);
        DB::purge('mysql');

        DB::connection('mysql')->statement("CREATE DATABASE IF NOT EXISTS `{$database}`");

        $this->info("Database {$database} is ready");
    }
}
