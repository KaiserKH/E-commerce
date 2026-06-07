# Deployment Guide

1. Copy `.env.example` to `.env` and fill in database, mail, and payment credentials.
2. Point the web server document root to `public/`.
3. Import `database/schema.sql` into MySQL or MariaDB.
4. Ensure `storage/`, `storage/logs/`, and `uploads/` are writable.
5. For Apache, use `public/.htaccess`.
6. For Nginx, adapt `deploy/nginx.conf.example`.
7. Use PHP 8.1+ with `pdo_mysql` enabled.

Shared hosting:

- Keep the app outside the web root when possible.
- If the host forces a single root, expose only `public/` and protect the rest with server rules.

VPS:

- Enable HTTPS.
- Set `APP_URL` to the production domain.
- Rotate secrets and keep `.env` out of the public directory.