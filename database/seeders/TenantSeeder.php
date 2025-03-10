<?php

namespace Database\Seeders;

use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $tenants = [
            [
                'name' => 'University of Glasgow',
                'domain' => 'uog.edulink.local',
                'database_name' => 'uog_edulink',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($tenants as $tenant) {
            Tenant::create($tenant);
        }
    }
}
