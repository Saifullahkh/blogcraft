# BlogCraft - Laravel Full-Stack Blog Platform

BlogCraft is a production-ready Laravel blog application with a public editorial frontend, custom authentication, role-protected administration, content CRUD, moderation, settings, uploads, SEO metadata, sitemap generation, and seeded demo content.

## Features

- Public homepage, blog listing, search, filters, category archives, tag archives, article pages, about page, contact page, and sitemap.
- Custom authentication: register, login, logout, remember me, forgot password, and reset password.
- Roles and authorization: `admin` and `user`, with protected `/admin/*` routes.
- Admin dashboard with statistics, recent posts, recent comments, most viewed posts, and recent users.
- Post CRUD with categories, tags, draft/published status, featured posts, publication dates, SEO fields, image upload, and a lightweight rich-text editor.
- Category, tag, comment, user, contact message, media, and website settings management.
- User profile editing, avatar upload, password change, and personal comment history.
- Moderated nested comments with pending/approved/rejected status.
- Dynamic settings for website name, description, logo, favicon, footer text, contact email, and social links.
- Secure image handling through Laravel Storage with validation and replacement/deletion of old files.
- Seeders and factories for admin, users, categories, tags, posts, comments, settings, messages, and newsletter data.

## Technology Stack

- Laravel 12.x
- PHP 8.2+ locally, PHP 8.3+ recommended for production
- MySQL 8+ for production
- Blade templates
- Tailwind CSS 4
- Vite
- Eloquent ORM
- Form Requests, middleware, gates, factories, and seeders

Composer selected Laravel 12 on this machine because the installed PHP version is 8.2.12. Composer reported Laravel 13 requires PHP `^8.3`, so upgrading PHP to 8.3+ is the path to Laravel 13.

## Requirements

- PHP 8.3+ recommended
- Composer 2+
- Node.js and npm
- MySQL 8+ or MariaDB 10.6+
- PHP extensions required by Laravel, including PDO, mbstring, openssl, tokenizer, xml, ctype, json, fileinfo, and curl

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
```

Configure MySQL in `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=blogwebsite
DB_USERNAME=root
DB_PASSWORD=
```

Create the database in MySQL, then run:

```bash
php artisan migrate --seed
php artisan storage:link
npm install
npm run build
php artisan serve
```

On Windows PowerShell, use `npm.cmd install` and `npm.cmd run build` if script execution blocks `npm`.

## Admin Login

Seeded development admin:

- Email: `admin@example.com`
- Password: `Password123!`

Change these credentials before any production deployment.

## Useful Commands

```bash
php artisan migrate:fresh --seed
php artisan route:list
php artisan test
npm run dev
npm run build
```

## Production Notes

- Set `APP_ENV=production`, `APP_DEBUG=false`, and a real `APP_URL`.
- Configure a production mailer for password reset email delivery.
- Use a queue worker if mail or background work is moved to queues.
- Run `npm run build` during deployment.
- Run `php artisan config:cache`, `php artisan route:cache`, and `php artisan view:cache` after environment variables are finalized.
- Point the web server document root to `public/`.
- Ensure `storage/` and `bootstrap/cache/` are writable by the web server.
- Use HTTPS and secure database credentials.

## Verification Performed

Local MySQL on this machine refused connections on `127.0.0.1:3306`, so migrations and tests were verified with SQLite using the same Laravel migrations and seeders.

Commands run successfully:

```bash
composer create-project laravel/laravel .
composer dump-autoload --no-scripts
php artisan package:discover
php artisan key:generate
php artisan route:list
php artisan migrate:fresh --seed   # verified with SQLite override
php artisan storage:link
php artisan view:cache
php artisan view:clear
npm.cmd install
npm.cmd run build
php artisan test                   # verified with SQLite override
```

HTTP smoke tests returned `200` for `/`, `/blog`, a seeded `/blog/{slug}`, `/about`, `/contact`, `/login`, `/sitemap.xml`, and `/admin/dashboard` after logging in as the seeded admin.
