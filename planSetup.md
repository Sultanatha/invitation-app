# Dokumentasi Project: Invitation App

Invitation App adalah backend Laravel 12 untuk undangan pernikahan. Aplikasi ini menyediakan REST API untuk landing page undangan, dashboard admin berbasis Blade untuk mengelola konten, dokumentasi API interaktif dengan Scalar, dan RBAC menggunakan Spatie Permission.

## 1. Kebutuhan Sistem

| Komponen | Versi Minimum | Catatan |
|---|---:|---|
| PHP | 8.2+ | Dibutuhkan oleh Laravel 12 |
| Composer | 2.x | Package manager PHP |
| Database | MySQL 8, PostgreSQL 13+, atau SQLite | Pilih salah satu |
| Ekstensi PHP | pdo_mysql atau pdo_pgsql, mbstring, openssl, fileinfo, curl | Sesuaikan dengan database |
| Node.js | 18+ | Opsional, hanya jika asset dibuild via Vite |
| Web server | php artisan serve, Apache, atau Nginx | Development cukup pakai built-in server |

Package utama:

- `laravel/framework` ^12.0
- `laravel/sanctum` untuk API token
- `spatie/laravel-permission` untuk RBAC
- `scalar/laravel` untuk dokumentasi API interaktif

## 2. Arsitektur Aplikasi

```text
Landing Page / Frontend
        |
        | GET /api/v1/invitation*
        | POST /api/v1/rsvp
        v
REST API Laravel
        |
        v
Database

Admin Dashboard /admin
        |
        | Blade + RBAC
        v
Konten Undangan, RSVP, User, Role
```

## 3. Modul Konten

| Modul | Tabel | Fungsi |
|---|---|---|
| Hero Section | `hero_sections` | Nama mempelai, tanggal acara, cover, kutipan pembuka |
| Mempelai | `couples` | Biodata pria dan wanita, orang tua, foto |
| Jadwal Acara | `event_schedules` | Akad, resepsi, waktu, lokasi |
| Cerita Cinta | `love_stories` | Timeline kisah cinta |
| Galeri | `galleries` | Kumpulan foto |
| Hadiah | `gifts` | Info bank, e-wallet, atau alamat kado |
| RSVP | `rsvps` | Konfirmasi kehadiran tamu |
| Settings | `settings` | Judul situs, deskripsi, warna tema, WhatsApp admin |
| User & Role | `users`, `roles`, `permissions` | Manajemen akses dashboard |

## 4. RBAC

Aplikasi menggunakan Spatie Permission. Setiap modul memiliki pola permission:

```text
view-{module}
create-{module}
update-{module}
delete-{module}
```

Contoh:

```text
view-hero
create-hero
update-hero
delete-hero
```

Role default:

| Role | Akses |
|---|---|
| `super-admin` | Semua permission, termasuk user dan role |
| `admin` | Semua permission konten, tanpa kelola user dan role |

User default dari seeder:

```text
Email    : admin@invitation.test
Password : password
Role     : super-admin
```

Ganti password setelah login pertama kali.

## 5. Struktur File Penting

```text
app/
  Models/
  Http/Controllers/
    Admin/
    Api/
    Auth/

database/
  migrations/
  seeders/

routes/
  web.php
  api.php

resources/views/admin/
  auth/
  layouts/
  dashboard.blade.php
  ...

config/
  permission.php
  scalar.php

public/
  openapi.yaml
```

## 6. Instalasi Dari Nol

```powershell
cd D:\Apps\PHP\Laravel

composer create-project laravel/laravel invitation-app
cd invitation-app

composer require spatie/laravel-permission
composer require laravel/sanctum
composer require scalar/laravel

copy .env.example .env
php artisan key:generate

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan vendor:publish --tag="scalar-config"

php artisan migrate
php artisan db:seed --class=RolePermissionSeeder
php artisan storage:link

php artisan serve
```

Dashboard:

```text
http://localhost:8000/admin/login
```

Dokumentasi API Scalar:

```text
http://localhost:8000/scalar
```

OpenAPI spec:

```text
http://localhost:8000/openapi.yaml
```

## 7. Konfigurasi Database

### MySQL

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=invitation_app
DB_USERNAME=root
DB_PASSWORD=
```

```bash
mysql -u root -p -e "CREATE DATABASE invitation_app;"
```

### PostgreSQL

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=invitation_app
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

```bash
createdb invitation_app
```

Pastikan ekstensi `pdo_pgsql` dan `pgsql` aktif di `php.ini`.

### SQLite

```bash
touch database/database.sqlite
```

```env
DB_CONNECTION=sqlite
```

## 8. REST API

| Method | Endpoint | Keterangan |
|---|---|---|
| GET | `/api/v1/invitation` | Semua data landing page |
| GET | `/api/v1/invitation/hero` | Hero section aktif |
| GET | `/api/v1/invitation/couples` | Data mempelai |
| GET | `/api/v1/invitation/events` | Jadwal acara |
| GET | `/api/v1/invitation/love-stories` | Cerita cinta |
| GET | `/api/v1/invitation/galleries` | Galeri foto |
| GET | `/api/v1/invitation/gifts` | Info hadiah atau rekening |
| POST | `/api/v1/rsvp` | Tamu submit RSVP |
| GET | `/api/v1/rsvp` | List RSVP, membutuhkan auth Sanctum dan permission `view-rsvp` |

Contoh submit RSVP:

```bash
curl -X POST http://localhost:8000/api/v1/rsvp \
  -H "Content-Type: application/json" \
  -d '{"guest_name":"Budi","attendance":"hadir","total_guest":2,"message":"Selamat ya!"}'
```

## 9. Dashboard Admin

Dashboard saat ini menggunakan Blade dan Tailwind CDN. Tampilan admin dimodernisasi dengan:

- Sidebar responsif
- Header sticky
- Kartu ringkasan RSVP
- Komposisi kehadiran
- Tabel RSVP terbaru yang lebih mudah dipindai
- Login screen centered yang lebih sederhana untuk admin panel internal

Halaman CRUD tetap menggunakan route dan controller yang sama, sehingga perubahan visual tidak mengubah alur bisnis.

## 10. Dokumentasi API Dengan Scalar

Dokumentasi API menggunakan package `scalar/laravel`.

Package yang ditambahkan:

```bash
composer require scalar/laravel
```

File konfigurasi dipublish dengan:

```bash
php artisan vendor:publish --tag="scalar-config"
```

File terkait:

| File | Fungsi |
|---|---|
| `config/scalar.php` | Konfigurasi route dan sumber OpenAPI untuk Scalar |
| `public/openapi.yaml` | OpenAPI spec untuk semua endpoint API |
| `composer.json` | Menyimpan dependency `scalar/laravel` |
| `composer.lock` | Lock dependency Scalar |

Konfigurasi Scalar yang digunakan:

```php
'path' => '/scalar',
'url' => '/openapi.yaml',
'configuration' => [
    'layout' => 'modern',
    'metaData' => [
        'title' => config('app.name').' API Documentation',
    ],
],
```

URL dokumentasi:

```text
http://localhost:8000/scalar
```

URL OpenAPI spec:

```text
http://localhost:8000/openapi.yaml
```

Endpoint yang sudah dicatat di `public/openapi.yaml`:

| Method | Endpoint | Status |
|---|---|---|
| GET | `/api/v1/invitation` | Terdokumentasi |
| GET | `/api/v1/invitation/hero` | Terdokumentasi |
| GET | `/api/v1/invitation/couples` | Terdokumentasi |
| GET | `/api/v1/invitation/events` | Terdokumentasi |
| GET | `/api/v1/invitation/love-stories` | Terdokumentasi |
| GET | `/api/v1/invitation/galleries` | Terdokumentasi |
| GET | `/api/v1/invitation/gifts` | Terdokumentasi |
| POST | `/api/v1/rsvp` | Terdokumentasi, termasuk body request dan validasi 422 |
| GET | `/api/v1/rsvp` | Terdokumentasi, termasuk bearer auth Sanctum |

Validasi OpenAPI:

```bash
npx @redocly/cli lint public/openapi.yaml
```

Hasil terakhir: spec valid. Warning yang tersisa hanya rekomendasi Redocly agar setiap endpoint GET publik mencantumkan response 4xx.

## 11. Catatan Perubahan Implementasi

Bagian ini mencatat perubahan yang sudah dilakukan pada project berjalan.

### Dokumentasi project

- `planSetup.md` ditulis ulang agar encoding bersih dan struktur dokumentasi lebih mudah dibaca.
- Karakter encoding rusak dan simbol diagram yang korup dihapus.
- Ditambahkan informasi setup Scalar, URL dokumentasi, dan URL OpenAPI spec.
- Ditambahkan catatan perubahan dashboard admin dan login screen.

### Dependency

- Menambahkan `scalar/laravel` versi `^0.2.1` ke `composer.json`.
- `composer.lock` ikut berubah karena dependency Scalar dikunci.

### Scalar dan OpenAPI

- Menambahkan `config/scalar.php` dari publish config package Scalar.
- Mengubah sumber dokumentasi Scalar dari contoh bawaan Scalar Galaxy menjadi `/openapi.yaml`.
- Mengubah title halaman Scalar menjadi `APP_NAME API Documentation`.
- Menambahkan `public/openapi.yaml` sebagai dokumen OpenAPI 3.1.0.
- Menambahkan security scheme `bearerAuth` untuk endpoint RSVP list yang memakai Sanctum.
- Menambahkan schema untuk `HeroSection`, `Couple`, `EventSchedule`, `LoveStory`, `Gallery`, `Gift`, `Rsvp`, paginator RSVP, dan validation error.

### Admin dashboard

- Mengubah layout utama admin di `resources/views/admin/layouts/app.blade.php`.
- Sidebar dibuat responsif dan tetap mengikuti permission `@can`.
- Header dashboard dibuat sticky.
- Alert success dan error dibuat lebih modern.
- Navigasi aktif dibuat lebih jelas.

### Halaman dashboard

- Mengubah `resources/views/admin/dashboard.blade.php`.
- Menambahkan kartu ringkasan RSVP.
- Menambahkan komposisi kehadiran dalam bentuk progress bar.
- Menambahkan tabel RSVP terbaru yang lebih mudah dipindai.
- Menambahkan ringkasan jumlah jadwal dan galeri.

### Halaman login

- Mengubah `resources/views/admin/auth/login.blade.php`.
- Login screen dibuat centered single-card.
- Panel kiri dekoratif dihapus karena aplikasi ini khusus admin panel internal.
- Styling form dibuat lebih bersih dengan fokus pada email, password, remember me, dan tombol masuk.

### Routing dan auth redirect

- Mengubah `bootstrap/app.php`.
- Menambahkan redirect guest ke route `admin.login`.
- Tujuannya agar akses `/admin/dashboard` tanpa login tidak mencari route default `login` dan tidak menghasilkan error 500.

```php
$middleware->redirectGuestsTo(fn () => route('admin.login'));
```

### Validasi yang sudah dilakukan

- `php artisan route:list --path=admin` berhasil menampilkan route admin.
- `php artisan route:list --path=scalar` berhasil menampilkan route Scalar.
- `php artisan route:list --path=api/v1` berhasil menampilkan endpoint API.
- `php artisan view:cache` berhasil, Blade template valid.
- `curl -I http://127.0.0.1:8000/admin/login` return `200`.
- `curl -I http://127.0.0.1:8000/` return `302` ke `/admin/login`.
- `curl -I http://127.0.0.1:8000/openapi.yaml` return `200`.
- `curl -I http://127.0.0.1:8000/scalar` return `200`.

### Catatan development server

Saat development, pernah ada beberapa proses `php artisan serve` berjalan bersamaan di port `8000`, sehingga browser sempat menampilkan `ERR_FAILED` atau request timeout.

Solusi:

```powershell
netstat -ano | findstr :8000
Stop-Process -Id <PID> -Force
php artisan serve --host=127.0.0.1 --port=8000
```

Gunakan satu proses server saja untuk port `8000`.

## 12. Troubleshooting

### Could not open input file: artisan

Pastikan terminal berada di root project Laravel.

```powershell
cd D:\Apps\PHP\Laravel\invitation-app
```

### could not find driver

Driver database belum aktif. Cek file `php.ini`:

```powershell
php --ini
```

Aktifkan ekstensi yang sesuai:

```ini
extension=pdo_pgsql
extension=pgsql
```

atau:

```ini
extension=pdo_mysql
```

### Foto tidak muncul

Jalankan:

```bash
php artisan storage:link
```

### Tidak bisa login

Pastikan user memiliki role `admin` atau `super-admin`.

### Sidebar kosong atau akses 403

Pastikan role user memiliki permission yang sesuai, misalnya `view-rsvp`, `view-hero`, atau `view-role`.

## 13. Rencana Pengembangan

- Landing page contoh yang mengonsumsi `/api/v1/invitation`
- Rate limiting untuk `POST /api/v1/rsvp`
- Export RSVP ke Excel atau PDF
- Multi-tenant untuk banyak undangan dalam satu aplikasi
- Build asset Tailwind via Vite untuk produksi
