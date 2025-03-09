-- login to mysql
mysql -u root -p

-- Create main application database
CREATE DATABASE IF NOT EXISTS central_edulink;

-- Create tenant databases
CREATE DATABASE IF NOT EXISTS uog_edulink;
CREATE DATABASE IF NOT EXISTS uoe_edulink;
CREATE DATABASE IF NOT EXISTS uoa_edulink;
CREATE DATABASE IF NOT EXISTS uos_edulink;
CREATE DATABASE IF NOT EXISTS usa_edulink;

-- Create application user if not exists
CREATE USER IF NOT EXISTS 'edu_link_admin'@'%' IDENTIFIED BY 'edu_link_admin';

-- Grant privileges to the application user for all databases
GRANT ALL PRIVILEGES ON central_edulink.* TO 'edu_link_admin'@'%';
GRANT ALL PRIVILEGES ON uog_edulink.* TO 'edu_link_admin'@'%';
GRANT ALL PRIVILEGES ON uoe_edulink.* TO 'edu_link_admin'@'%';
GRANT ALL PRIVILEGES ON uoa_edulink.* TO 'edu_link_admin'@'%';
GRANT ALL PRIVILEGES ON uos_edulink.* TO 'edu_link_admin'@'%';
GRANT ALL PRIVILEGES ON usa_edulink.* TO 'edu_link_admin'@'%';

-- Grant create database privilege to allow tenant creation
GRANT CREATE ON *.* TO 'edu_link_admin'@'%';

-- Flush privileges to apply changes
FLUSH PRIVILEGES;

-- Use the main application database
USE central_edulink;

-- Create tenants table if not exists
CREATE TABLE IF NOT EXISTS tenants (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    domain VARCHAR(255) NOT NULL,
    database_name VARCHAR(255) NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    PRIMARY KEY (id),
    UNIQUE KEY tenants_domain_unique (domain),
    UNIQUE KEY tenants_database_name_unique (database_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert tenant records
INSERT INTO tenants (name, domain, database_name, is_active, created_at, updated_at) VALUES
('University of Glasgow', 'uog.edulink.local', 'uog_edulink', 1, NOW(), NOW()),
('University of Edinburgh', 'uoe.edulink.local', 'uoe_edulink', 1, NOW(), NOW()),
('University of Aberdeen', 'uoa.edulink.local', 'uoa_edulink', 1, NOW(), NOW()),
('University of Strathclyde', 'uos.edulink.local', 'uos_edulink', 1, NOW(), NOW()),
('University of St Andrews', 'usa.edulink.local', 'usa_edulink', 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE updated_at = NOW();
