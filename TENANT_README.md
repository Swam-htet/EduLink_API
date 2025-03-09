# Multi-Tenant Architecture

This application uses a database-per-tenant multi-tenant architecture. Each tenant has its own database, and the application dynamically switches between databases based on the subdomain of the request.

## How It Works

1. **Tenant Identification**: The application identifies the tenant based on the subdomain of the request. For example, if the request is made to `tenant1.example.com`, the application will look for a tenant with the domain `tenant1`.

2. **Database Connection**: Once the tenant is identified, the application dynamically configures a database connection to the tenant's database and sets it as the default connection for the request.

3. **Repositories**: All database operations are performed through repositories that use the tenant connection.

## Components

### Tenant Model

The `Tenant` model represents a tenant in the system. It has the following attributes:

-   `name`: The name of the tenant
-   `domain`: The subdomain of the tenant
-   `database`: The name of the tenant's database
-   `is_active`: Whether the tenant is active

### TenantService

The `TenantService` is responsible for identifying the tenant and configuring the database connection. It provides the following methods:

-   `getTenant()`: Get the current tenant
-   `setTenant(Tenant $tenant)`: Set the current tenant and configure the database connection
-   `identifyTenantByDomain(string $domain)`: Identify a tenant by its domain
-   `resetConnection()`: Reset the database connection to the default

### TenantMiddleware

The `TenantMiddleware` is responsible for identifying the tenant based on the subdomain of the request and configuring the database connection. It is applied to all web and API routes.

### BaseRepository

The `BaseRepository` is a base class for all repositories. It uses the tenant connection for all database operations.

## Creating a New Tenant

To create a new tenant, use the `tenant:create` command:

```bash
php artisan tenant:create "Tenant Name" "subdomain" "database_name"
```

This command will:

1. Create a new database for the tenant
2. Create a new tenant record in the central database
3. Run the tenant-specific migrations on the tenant's database

## Tenant-Specific Migrations

Tenant-specific migrations are stored in the `database/migrations/tenant` directory. These migrations are run on each tenant's database when the tenant is created.

## Environment Variables

The following environment variables are used for tenant-specific database connections:

```
TENANT_DB_CONNECTION=mysql
TENANT_DB_HOST=127.0.0.1
TENANT_DB_PORT=3306
TENANT_DB_USERNAME=root
TENANT_DB_PASSWORD=
```

## Usage

### Creating a New Repository

To create a new repository for a tenant-specific model, extend the `BaseRepository` class:

```php
namespace App\Repositories;

use App\Models\YourModel;
use App\Services\TenantService;

class YourModelRepository extends BaseRepository
{
    public function __construct(TenantService $tenantService)
    {
        parent::__construct($tenantService);
    }

    protected function setModel(): void
    {
        $this->model = new YourModel();
    }
}
```

### Using a Repository

Inject the repository into your controller or service:

```php
namespace App\Http\Controllers;

use App\Repositories\YourModelRepository;

class YourController extends Controller
{
    protected $repository;

    public function __construct(YourModelRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $items = $this->repository->all();
        return response()->json($items);
    }
}
```

## Notes

-   The central database contains the `tenants` table, which stores information about all tenants.
-   Each tenant has its own database, which contains tenant-specific tables.
-   The application automatically switches between databases based on the subdomain of the request.
-   The `TenantMiddleware` is applied to all web and API routes, so all requests are tenant-aware.
