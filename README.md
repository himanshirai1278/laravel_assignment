# Laravel Multi-Auth + Real-time + Web Push + 100k Import (Starter Overlay)

This repository is an **overlay** that configures a fresh Laravel 11 app to meet your assignment requirements.

## What you get
- Admin & Customer authentication via separate guards, middleware, routes, and dashboards.
- Product CRUD with image upload and **chunked** CSV import (100k+) using **queues** and **Spout** (memory-efficient).
- Order placement (Customer) + status management (Admin: Pending/Shipped/Delivered).
- **Real-time** order status broadcasts with **Laravel Websockets** (no polling) + presence channels storing online/offline in DB.
- **Browser Push Notifications** using `minishlink/web-push` with VAPID keys.
- Minimal Blade UI.
- Feature + Unit tests for import and order flow.
- `products_sample_import.csv` with sample data.

> This overlay does **not** include the Laravel framework vendor files. The setup script will scaffold Laravel and merge these files.

---

## Quick Setup

### Prerequisites
- PHP 8.2+
- Composer
- Node 18+ & npm
- Redis (recommended for queues) **or** database queue
- SQLite/MySQL/PostgreSQL
- Open ports: 6001 (websockets), app port

### 1) Run setup (Linux/macOS PowerShell users can translate commands)
```bash
chmod +x scripts/setup.sh
./scripts/setup.sh myapp
```

This will:
- `composer create-project laravel/laravel myapp`
- install packages: `beyondcode/laravel-websockets`, `minishlink/web-push`, `box/spout`
- copy all overlay files into `myapp`
- run `php artisan migrate --seed`
- build assets

### 2) Configure `.env`
- Set DB credentials
- Set QUEUE_CONNECTION=redis (or database) and broadcast driver to `pusher`
- Set WEBSOCKETS_HOST/PORT if needed
- Generate VAPID keys:
```bash
php artisan webpush:vapid
```
Populate `VAPID_PUBLIC_KEY` & `VAPID_PRIVATE_KEY` in `.env`.

### 3) Run services
```bash
php artisan websockets:serve
php artisan queue:work
php artisan serve
npm run dev
```

### 4) Login
- Admin: `admin@example.com` / `password`
- Customer: `customer@example.com` / `password`

### 5) Bulk Import (100k+)
Go to `/admin/import` and upload `products_sample_import.csv`. Missing image uses default.

---

## Notes
- No AJAX polling. Real-time via websockets + push.
- Presence channel shows Admin/Customer online; presence is also stored to DB on join/leave.
- Tests: `php artisan test`

---

## Packages
- Websockets: `beyondcode/laravel-websockets`
- Push: `minishlink/web-push`
- Import: `box/spout`

---

## Scripts
See `scripts/setup.sh` for full setup steps.
