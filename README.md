# EduLink API

EduLink API is a multi-tenant education management system API that helps educational institutions manage their courses, students, staff, classes, and attendance.

## System Requirements

-   Docker and Docker Compose
-   Git
-   Composer (for local development)
-   PHP 8.1 or higher (for local development)

## Project Structure

The project follows a multi-tenant architecture where each tenant has its own:

-   Course management
-   Student management
-   Staff/Tutor management
-   Class scheduling
-   Attendance tracking
-   Enrollment management

## Getting Started

### 1. Clone the Repository

```bash
git clone <repository-url>
cd edu_link_api
```

### 2. Environment Setup

Copy the example environment file:

```bash
cp .env.example .env
```

Update the following variables in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=edu_link
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 3. Docker Setup

The project uses Docker for containerization. To start the services:

```bash
docker-compose up -d
```

This will start the following services:

-   PHP-FPM
-   Nginx
-   MySQL
-   Redis (for caching)

### 4. MySQL Database Setup

The project includes a `mysql.sql` file that contains:

-   Central database creation (`central_edulink`)
-   Sample tenant databases creation
-   User privileges setup
-   Initial tenant table schema
-   Sample tenant data

To initialize the database:

```bash
# Copy the SQL file to MySQL container
docker-compose cp mysql.sql mysql:/mysql.sql

# Execute the SQL file
docker-compose exec mysql mysql -u root -p < mysql.sql
```

The `mysql.sql` file handles:

-   Creating the central database (`central_edulink`)
-   Creating sample tenant databases:
    -   `uog_edulink` (University of Glasgow)
    -   `uoe_edulink` (University of Edinburgh)
    -   `uoa_edulink` (University of Aberdeen)
    -   `uos_edulink` (University of Strathclyde)
    -   `usa_edulink` (University of St Andrews)
-   Setting up application user (`edu_link_admin`) with necessary permissions
-   Creating the tenants table in the central database
-   Inserting sample tenant records

Database User Configuration:

```sql
Username: edu_link_admin
Password: edu_link_admin
Privileges: ALL PRIVILEGES on tenant databases, CREATE privilege for new tenants
```

To manually connect to MySQL:

```bash
# Connect to MySQL container
docker-compose exec mysql mysql -u edu_link_admin -p

# List databases
SHOW DATABASES;

# Switch to central database
USE central_edulink;

# View tenants
SELECT * FROM tenants;
```

### 5. Database Migrations

The project uses two types of migrations:

1. Central database migrations (for tenant management)
2. Tenant-specific migrations (for educational data)

#### Running Migrations

First, run the central migrations:

```bash
docker-compose exec app php artisan migrate
```

For tenant migrations, use:

```bash
docker-compose exec app php artisan tenants:migrate
```

Migration files are organized as follows:

-   Central migrations: `database/migrations/`
-   Tenant migrations: `database/migrations/tenants/`

### 6. Database Seeding (Optional)

To seed the database with sample data:

```bash
# Central database seeding
docker-compose exec app php artisan db:seed

# Tenant database seeding
docker-compose exec app php artisan tenants:seed
```

## API Documentation

API documentation is available at:

-   Development: `http://localhost:8000/api/documentation`
-   Production: `https://your-domain.com/api/documentation`

## Tenant Management

### Creating a New Tenant

```bash
docker-compose exec app php artisan tenant:create
```

### Running Migrations for Specific Tenant

```bash
docker-compose exec app php artisan tenants:migrate --tenant=tenant_id
```

## Development Guidelines

### Adding New Migrations

1. For central database:

```bash
docker-compose exec app php artisan make:migration create_central_table
```

2. For tenant database:

```bash
docker-compose exec app php artisan make:migration tenant/create_tenant_table
```

### Model Structure

Tenant models are located in:

-   `app/Models/Tenants/`

Each model includes:

-   Soft deletes
-   Proper relationships
-   Fillable attributes
-   Type casting

## Troubleshooting

### Common Issues

1. Database connection issues:

```bash
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan cache:clear
```

2. Permission issues:

```bash
docker-compose exec app chmod -R 777 storage bootstrap/cache
```

3. Composer issues:

```bash
docker-compose exec app composer install --no-scripts
```

### Logs

To view logs:

```bash
# Application logs
docker-compose exec app tail -f storage/logs/laravel.log

# Nginx logs
docker-compose logs -f nginx
```

## Contributing

1. Create a feature branch
2. Make your changes
3. Run tests
4. Submit a pull request

## License

[Your License]
