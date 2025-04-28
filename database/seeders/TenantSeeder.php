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
                'name' => 'Yangon International School',
                'domain' => 'yis_edulink',
                'database_name' => 'yis_edulink',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];

        foreach ($tenants as $tenant) {
            Tenant::create($tenant);
        }
    }
}
