# EduLink API

EduLink API is a multi-tenant education management system API that helps educational institutions manage their courses, students, staff, classes, and attendance.

## System Requirements

-   Docker and Docker Compose
-   Git
-   Composer (for local development)
-   PHP 8.1 or higher (for local development)

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

### 3. Docker Setup

The project uses Docker for containerization. To start the services:

```bash
docker-compose up -d --build
```

### 4. Database Migrations

The project uses two types of migrations:

1. Central database migrations (for tenant management)
2. Tenant-specific migrations (for educational data)

#### Running Migrations

First, run the central migrations:

```bash
docker-compose exec app php artisan migrate
```

Then, run the seeder for central db

```bash
docker-compose exec app php artisan db:seed
```

For tenant migrations, use:

```bash
docker-compose exec app php artisan tenants:migrate
```

Migration files are organized as follows:

-   Central migrations: `database/migrations/`
-   Tenant migrations: `database/migrations/tenants/`
