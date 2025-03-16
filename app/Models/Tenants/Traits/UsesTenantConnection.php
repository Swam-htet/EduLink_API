<?php

namespace App\Models\Tenants\Traits;

trait UsesTenantConnection
{
    // Default connection to tenant database
    public function getConnectionName()
    {
        return 'tenant';
    }

    // Allow dynamic connection switching
    public function setConnection($name)
    {
        $this->connection = $name;
        return $this;
    }
}
