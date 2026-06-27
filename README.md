# Invitation App — Laravel 12 (API + Admin Dashboard + RBAC)

Source code ini adalah **kumpulan file tambahan** untuk di-_drop_ ke project Laravel 12 baru.
(Bukan project penuh, karena environment ini tidak punya akses ke Packagist/Composer registry —
jadi instalasi composer harus dilakukan di komputer/server kamu sendiri.)

## Struktur fitur

- **Admin Dashboard** (Blade + Tailwind via CDN) di `/admin`
  - Hero Section, Mempelai, Jadwal Acara, Cerita Cinta, Galeri, Hadiah, RSVP, Settings
  - Manajemen User & Role (RBAC) — hanya bisa diakses role yang punya permission `view-user` / `view-role` (default: `super-admin`)
- **REST API publik** di `/api/v1/*` untuk dikonsumsi landing page undangan (HTML statis, Vue, React, dll)
- **RBAC** menggunakan **Spatie laravel-permission**, role default: `super-admin` (akses semua) dan `admin` (akses konten, tanpa kelola user/role)

## Langkah Instalasi

```bash
# 1. Buat project Laravel 12 baru
composer create-project laravel/laravel invitation-app
cd invitation-app

# 2. Install Spatie Permission & Sanctum
composer require spatie/laravel-permission
composer require laravel/sanctum

# 3. Copy semua file dari paket ini ke project (timpa file yang sama)
#    - app/Models/*
#    - app/Http/Controllers/*
#    - database/migrations/*
#    - database/seeders/*
#    - routes/web.php & routes/api.php
#    - bootstrap/app.php
#    - resources/views/admin/*
#    - config/permission.php

# 4. Publish migration Spatie (jika belum ada) lalu migrate
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate

# 5. Seed role, permission, dan user super-admin default
php artisan db:seed --class=RolePermissionSeeder

# 6. Link storage (untuk upload foto/gambar)
php artisan storage:link

# 7. Jalankan
php artisan serve
```

## Login Dashboard Default

```
URL    : http://localhost:8000/admin/login
Email  : admin@invitation.test
Password: password
```

**Ganti password ini setelah login pertama kali**, lewat menu Manajemen User.

## Endpoint API Utama (Public)

Dokumentasi interaktif API tersedia via Scalar:

```
http://localhost:8000/scalar
```

OpenAPI spec mentah tersedia di:

```
http://localhost:8000/openapi.yaml
```

| Method | Endpoint | Keterangan |
|---|---|---|
| GET | `/api/v1/invitation` | Semua data landing page sekali fetch (hero, couples, events, love stories, gallery, gifts, settings) |
| GET | `/api/v1/invitation/hero` | Data hero section aktif |
| GET | `/api/v1/invitation/couples` | Data mempelai |
| GET | `/api/v1/invitation/events` | Jadwal acara |
| GET | `/api/v1/invitation/love-stories` | Cerita cinta |
| GET | `/api/v1/invitation/galleries` | Galeri foto |
| GET | `/api/v1/invitation/gifts` | Info rekening/hadiah |
| POST | `/api/v1/rsvp` | Tamu mengisi RSVP |

Contoh response `/api/v1/invitation`:
```json
{
  "success": true,
  "data": {
    "settings": { "site_title": "...", "theme_color": "#000000" },
    "hero": { "groom_name": "...", "bride_name": "...", "event_date": "2026-08-10" },
    "couples": [...],
    "events": [...],
    "love_stories": [...],
    "galleries": [...],
    "gifts": [...]
  }
}
```

Contoh submit RSVP:
```bash
curl -X POST http://localhost:8000/api/v1/rsvp \
  -H "Content-Type: application/json" \
  -d '{"guest_name":"Budi","attendance":"hadir","total_guest":2,"message":"Selamat ya!"}'
```

## Struktur RBAC

Permission dibuat otomatis per modul dengan format `{action}-{module}`, contoh:
`view-hero`, `create-hero`, `update-hero`, `delete-hero`, dst, untuk modul:
`dashboard, hero, couple, event, love-story, gallery, gift, rsvp, setting, user, role`.

- **super-admin** → semua permission
- **admin** → semua permission konten, TANPA `user` & `role`

Kamu bisa menambah role baru lewat dashboard (`/admin/roles`) dan mencentang permission yang diinginkan — ini akan otomatis membatasi menu sidebar & akses controller (lewat middleware `permission:` dan `@can` di Blade).

## Catatan

- Semua upload gambar disimpan di `storage/app/public` — jangan lupa `php artisan storage:link`.
- Untuk produksi: ganti Tailwind CDN dengan build asset (Vite) dan tambahkan rate-limiting pada endpoint `POST /api/v1/rsvp` agar tidak disalahgunakan (spam submit).
- Jika landing page dibuat terpisah (SPA/React/Vue), cukup fetch endpoint API di atas — tidak perlu autentikasi karena bersifat publik (read-only, kecuali RSVP).
