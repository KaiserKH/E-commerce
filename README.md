# Ecommerce Pro

Pure PHP 8+ eCommerce application with MVC-inspired structure, PDO database access, Bootstrap 5 UI, role-based authentication, cart and checkout, contact/newsletter flows, and deployment assets for Apache and Nginx.

## Quick Start

1. Copy `.env.example` to `.env` and set your database credentials.
2. Import `database/schema.sql` and optionally `database/seeds/seed.sql`.
3. Point your document root to `public/`.
4. Ensure `storage/` and `uploads/` are writable.
5. Use PHP 8.1+ with `pdo_mysql` enabled.

## Seed Accounts

- Admin: `admin@example.com`
- Vendor: `vendor@example.com`
- Customer: `customer@example.com`
- Password for all seed accounts: `Password123!`

## Project Layout

- `app/Core` core framework classes
- `app/Controllers` HTTP controllers
- `app/Models` database models
- `app/Views` templates
- `app/Services` domain services
- `database/schema.sql` full schema
- `database/seeds/seed.sql` starter data
- `deploy/nginx.conf.example` Nginx sample# E-commerce
