# 💌 Invitation App

Aplikasi undangan digital berbasis web yang dibangun dengan **Laravel 12**, dilengkapi **Admin Dashboard**, **REST API publik**, dan sistem **RBAC** menggunakan Spatie Laravel Permission.

---

## 🚀 Fitur Utama

- **Admin Dashboard** (Blade + Tailwind CSS) di `/admin`
  - Manajemen Undangan, Hero Section, Mempelai, Jadwal Acara, Cerita Cinta, Galeri, Hadiah, RSVP, dan Settings
  - Manajemen User & Role berbasis RBAC
- **REST API Publik** di `/api/v1/*` untuk dikonsumsi landing page (HTML statis, Vue, React, dll)
- **RBAC** dengan Spatie Laravel Permission — role default: `super-admin` & `admin`
- **Dokumentasi API interaktif** via Scalar di `/scalar`

---

## 🛠️ Tech Stack

| Layer | Teknologi |
|---|---|
| Backend | Laravel 12 |
| Database | PostgreSQL |
| Auth & API | Laravel Sanctum |
| RBAC | Spatie Laravel Permission |
| Frontend (Admin) | Blade + Tailwind CSS (CDN) |
| API Docs | Scalar / OpenAPI |

---

## ⚙️ Instalasi

### Prasyarat

- PHP >= 8.2
- Composer
- PostgreSQL
- Node.js & NPM (opsional, untuk build asset)

### Langkah-langkah

```bash
# 1. Clone repository
git clone https://github.com/Sultanatha/invitation-app.git
cd invitation-app

# 2. Install dependency PHP
composer install

# 3. Salin file environment
cp .env.example .env

# 4. Generate application key
php artisan key:generate
```

### Konfigurasi Database (PostgreSQL)

Edit file `.env` dan sesuaikan konfigurasi berikut:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=invitation_app
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
```

### Lanjutan Setup

```bash
# 5. Publish migration Spatie Permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"

# 6. Jalankan migration
php artisan migrate

# 7. Seed role, permission, dan user default
php artisan db:seed --class=RolePermissionSeeder

# 8. Link storage untuk upload gambar
php artisan storage:link

# 9. Jalankan server lokal
php artisan serve
```

---

## 🔐 Login Default

| Field | Value |
|---|---|
| URL | `http://localhost:8000/admin/login` |
| Email | `admin@invitation.test` |
| Password | `password` |

> ⚠️ **Ganti password setelah login pertama kali** melalui menu Manajemen User.

---

## 📡 Endpoint API

Dokumentasi interaktif tersedia di: `http://localhost:8000/scalar`  
OpenAPI spec: `http://localhost:8000/openapi.yaml`

| Method | Endpoint | Keterangan |
|---|---|---|
| GET | `/api/v1/invitation` | Semua data landing page untuk undangan default (hero, couples, events, dll) |
| GET | `/api/v1/invitations/{slug}` | Semua data landing page untuk undangan tertentu |
| GET | `/api/v1/invitation/hero` | Data hero section aktif |
| GET | `/api/v1/invitation/couples` | Data mempelai |
| GET | `/api/v1/invitation/events` | Jadwal acara |
| GET | `/api/v1/invitation/love-stories` | Cerita cinta |
| GET | `/api/v1/invitation/galleries` | Galeri foto |
| GET | `/api/v1/invitation/gifts` | Info rekening / hadiah |
| POST | `/api/v1/rsvp` | Submit RSVP tamu untuk undangan default |
| POST | `/api/v1/invitations/{slug}/rsvp` | Submit RSVP tamu untuk undangan tertentu |

## Halaman Publik Undangan

Setiap undangan memiliki halaman publik berdasarkan slug:

```text
http://localhost:8000/{slug}
```

Contoh:

```text
http://localhost:8000/default
http://localhost:8000/budi-siti
```

Alur admin:

1. Login ke `/admin/login`.
2. Buka menu **Undangan**.
3. Tambah undangan baru dan isi judul, slug, template, dan status publik.
4. Isi **Frontend URL** dengan domain FE utama jika halaman undangan memakai FE terpisah, misalnya `https://frontend-kamu.com`. Sistem akan menambahkan slug menjadi `https://frontend-kamu.com/{slug}`. Jika kosong, sistem memakai halaman lokal `/{slug}`.
5. Klik **Kelola** pada undangan tersebut.
6. Isi Hero, Mempelai, Jadwal Acara, Galeri, Hadiah, RSVP, dan Settings seperti biasa.
7. Klik **Preview** atau buka `/{slug}`.

**Contoh submit RSVP:**

```bash
curl -X POST http://localhost:8000/api/v1/rsvp \
  -H "Content-Type: application/json" \
  -d '{"guest_name":"Budi","attendance":"hadir","total_guest":2,"message":"Selamat ya!"}'
```

**Contoh submit RSVP untuk undangan tertentu:**

```bash
curl -X POST http://localhost:8000/api/v1/invitations/budi-siti/rsvp \
  -H "Content-Type: application/json" \
  -d '{"guest_name":"Budi","attendance":"hadir","total_guest":2,"message":"Selamat ya!"}'
```

---

## 👥 Struktur RBAC

Permission dibuat otomatis per modul dengan format `{action}-{module}`.

| Role | Akses |
|---|---|
| `super-admin` | Semua permission (termasuk user & role) |
| `admin` | Semua konten, **tanpa** akses user & role |

**Modul yang tersedia:** `dashboard`, `hero`, `couple`, `event`, `love-story`, `gallery`, `gift`, `rsvp`, `setting`, `user`, `role`

Role baru dapat dibuat lewat dashboard di `/admin/roles`.

---

## 📁 Struktur Direktori Utama

```
invitation-app/
├── app/
│   ├── Http/Controllers/     # Controller API & Admin
│   └── Models/               # Eloquent Models
├── database/
│   ├── migrations/           # Migrasi database
│   └── seeders/              # Seeder role & permission
├── resources/views/admin/    # Blade views dashboard
├── routes/
│   ├── api.php               # Route API publik
│   └── web.php               # Route admin & web
└── storage/app/public/       # Upload gambar
```

---

## 📝 Catatan Penting

- Semua upload gambar disimpan di `storage/app/public` — pastikan sudah menjalankan `php artisan storage:link`.
- Data konten undangan dipisahkan dengan `invitation_id`. Endpoint lama memakai undangan default, sedangkan endpoint `/api/v1/invitations/{slug}` mengambil data sesuai slug.
- Untuk **produksi**: ganti Tailwind CDN dengan build asset via Vite, dan tambahkan rate-limiting pada endpoint `POST /api/v1/rsvp`.
- Jika landing page dibuat terpisah (React/Vue/SPA), cukup consume endpoint API — tidak perlu autentikasi karena bersifat publik (read-only, kecuali RSVP).

---

## 📄 Lisensi

Proyek ini bersifat privat. Seluruh hak cipta dipegang oleh pemilik repository.
