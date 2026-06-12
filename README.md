# Tugas Akhir Pemweb

## SIROMA

**Sistem Informasi Rekrutmen Organisasi Mahasiswa**

* Nama aplikasi: `SIROMA`
* Repository: `siroma`
* Database: `siroma_db`

## Urutan Pengembangan

```text
1. Membuat project Laravel
2. Menginstal Filament, Spatie Permission, dan Shield
3. Membuat database kosong dan mengatur .env
4. Mengubah struktur SQL lama menjadi migration Laravel
5. Membuat model dan relasi Eloquent
6. Membuat migration view, stored procedure, dan trigger
7. Menjalankan migration
8. Membuat seeder dan data awal
9. Menjalankan setup Filament Shield
10. Membuat Filament Resource
11. Menghasilkan permission dan super admin
12. Menguji CRUD, relasi, upload, autentikasi, dan RBAC
```

## 1. Membuat Project

```bash
composer create-project laravel/laravel siroma "12.*"

cd siroma

php artisan key:generate

npm install
```

## 2. Instalasi Package

### Filament

```bash
composer require filament/filament:"~5.0"

php artisan filament:install --panels
```

### Spatie Laravel Permission

```bash
composer require spatie/laravel-permission

php artisan vendor:publish \
    --provider="Spatie\Permission\PermissionServiceProvider"
```

### Filament Shield

```bash
composer require bezhansalleh/filament-shield

php artisan vendor:publish \
    --tag="filament-shield-config"
```

> Jangan jalankan `shield:setup` sebelum migration dan konfigurasi model `User` selesai.

## 3. Konfigurasi Database

Buat database kosong:

```sql
CREATE DATABASE siroma_db
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;
```

Atur file `.env`:

```env
APP_NAME=SIROMA
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=siroma_db
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=public
```

## 4. Membuat Model, Migration, dan Factory

Model `User` sudah tersedia dari Laravel. Sesuaikan migration `users` dengan struktur database SIROMA.

Buat model tabel lainnya:

```bash
php artisan make:model Organization -mf
php artisan make:model Division -mf
php artisan make:model OrganizationMember -mf
php artisan make:model RecruitmentPeriod -mf
php artisan make:model Application -mf
php artisan make:model ApplicationPreference -mf
php artisan make:model ApplicationDocument -mf
php artisan make:model ApplicationStatusHistory -mf
```

Keterangan:

```text
-m = membuat migration
-f = membuat factory
```

> Command tersebut tidak membuat seeder. Seeder dibuat dengan `php artisan make:seeder`.

Isi seluruh migration berdasarkan SQL lama sebelum menjalankan `php artisan migrate`.

## 5. Membuat Migration Komponen Database

```bash
php artisan make:migration create_siroma_views
php artisan make:migration create_siroma_stored_procedures
php artisan make:migration create_siroma_triggers
```

Urutan migration:

```text
Tabel → Index → View → Stored Procedure → Trigger
```

## 6. Menjalankan Migration

Jalankan setelah seluruh migration selesai:

```bash
php artisan optimize:clear

php artisan migrate

php artisan migrate:status
```

Untuk mengulang database selama pengembangan:

```bash
php artisan migrate:fresh
```

## 7. Membuat Seeder

```bash
php artisan make:seeder RolePermissionSeeder
php artisan make:seeder UserSeeder
php artisan make:seeder SiromaSeeder
```

Jalankan:

```bash
php artisan db:seed
```

Atau:

```bash
php artisan migrate:fresh --seed
```

## 8. Setup Filament Shield

Tambahkan trait `HasRoles` pada model `User`.

Pastikan konfigurasi:

```php
'auth_provider_model' => App\Models\User::class,
```

Jalankan:

```bash
php artisan shield:setup
```

## 9. Membuat Filament Resource

```bash
php artisan make:filament-resource User --generate
php artisan make:filament-resource Organization --generate
php artisan make:filament-resource Division --generate
php artisan make:filament-resource RecruitmentPeriod --generate
php artisan make:filament-resource Application --generate
```

Generate permission:

```bash
php artisan shield:generate --all --panel=admin
```

Buat super admin:

```bash
php artisan shield:super-admin --panel=admin
```

## 10. Storage dan Menjalankan Project

```bash
php artisan storage:link
```

Jalankan backend:

```bash
php artisan serve
```

Jalankan frontend:

```bash
npm run dev
```

Akses panel:

```text
http://localhost:8000/admin
```
