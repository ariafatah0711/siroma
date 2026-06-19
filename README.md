# Tugas Akhir Pemweb
## SIROMA
**Sistem Informasi Rekrutmen Organisasi Mahasiswa**

* Nama aplikasi: `SIROMA`
* Repository: `siroma`
* Database: `siroma_db`

### Struktur Folder

```
siroma/
├── app/                          # Backend (Laravel PHP)
│   ├── Filament/Admin/           #   Admin Panel (FE Admin)
│   │   ├── Resources/            #     CRUD Resource
│   │   │   ├── Applications/
│   │   │   ├── ApplicationDocuments/
│   │   │   ├── Divisions/
│   │   │   ├── OrganizationMembers/
│   │   │   ├── Organizations/
│   │   │   ├── RecruitmentPeriods/
│   │   │   └── Users/
│   │   └── Widgets/              #     Dashboard widgets
│   ├── Http/Controllers/         #   Web Controllers (Public FE)
│   ├── Mail/                     #   Email classes
│   ├── Models/                   #   Eloquent models
│   ├── Policies/                 #   Authorization policies
│   └── Providers/                #   Service providers
│
├── bootstrap/                    # App bootstrapping
├── config/                       # Konfigurasi aplikasi
├── database/                     # Database
│   ├── factories/                #   Factory (dummy data)
│   ├── migrations/               #   Migration (struktur tabel)
│   ├── seeders/                  #   Seeder (data awal)
│   └── sql/                      #   SQL cadangan/ekspor
│
├── public/                       # Publicly accessible (entry point)
│   ├── build/                    #   Vite manifest
│   ├── css/                      #   Compiled CSS
│   ├── fonts/                    #   Font assets
│   ├── js/                       #   Compiled JS
│   └── storage/                  #   Symlink ke storage/app/public
│
├── resources/                    # Frontend (Public FE)
│   ├── css/                      #   Source CSS
│   ├── js/                       #   Source JS
│   └── views/                    #   Blade template (HTML)
│       ├── components/           #     Komponen reusable
│       ├── emails/               #     Template email
│       ├── layouts/              #     Layout utama
│       └── pages/                #     Halaman publik
│           ├── applications/
│           ├── auth/
│           ├── organizations/
│           ├── profile/
│           └── recruitments/
│
├── routes/                       # Definisi route
│   ├── web.php                   #   Route publik
│   └── console.php               #   Route CLI
│
├── storage/                      # Storage (logs, cache, upload)
├── tests/                        # Automated tests
├── vendor/                       # Composer dependencies
└── node_modules/                 # NPM dependencies
```

## Setup Local
```bash
git clone https://github.com/ariafatah0711/siroma.git
cd siroma

# Install dependency PHP
composer install
copy .env.example .env
php artisan key:generate
```

> ubah konfigurasi database di file `.env` sesuai dengan pengaturan lokal Anda.

```bash
# Install dependency frontend
npm install

# Buat tabel dan data awal
php artisan migrate:fresh
php artisan migrate --seed

# Dibutuhkan untuk upload dokumen publik
php artisan storage:link

# Build CSS dan JavaScript
npm run build

# Jalankan aplikasi
php artisan serve
```

---

## Setup Production (masih gagal di InfinityFree)
- Login ke InfinityFree, buat akun hosting baru.
- Masuk ke Control Panel (cPanel) mereka.
- Buka MySQL Databases, bikin database baru (misal: epiz_xxx_siroma_db). Catat detail DB Host, User, dan Password-nya.
- Buka Online File Manager, lu bakal nemu folder bernama htdocs.
- buat zip dari project ini lalu upload ke htdocs, terus extract.
- Buka file `.env` di htdocs, ubah konfigurasi database sesuai dengan yang dibuat di InfinityFree.

---

# Development Notes
## Urutan Pengembangan
```text
1. Membuat project Laravel
2. Menginstal Filament dan Spatie Permission
3. Membuat database kosong dan mengatur .env
4. Mengubah struktur SQL lama menjadi migration Laravel
5. Membuat model dan relasi Eloquent
6. Membuat migration view, stored procedure, dan trigger
7. Menjalankan migration
8. Membuat seeder dan data awal
9. Membuat role dan permission dengan Spatie
10. Membuat Filament Resource
11. Mengatur akses resource berdasarkan role/permission
12. Menguji CRUD, relasi, upload, autentikasi, dan RBAC
```

### 1. Membuat Project

```bash
composer create-project laravel/laravel siroma "12.*"

cd siroma

php artisan key:generate

npm install
```

### 2. Instalasi Package

#### Filament

```bash
composer require filament/filament:"~5.0"

php artisan filament:install --panels
```

#### Spatie Laravel Permission

```bash
composer require spatie/laravel-permission

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

> Project ini memakai Laravel 12, Filament 5, dan Spatie Permission 8. Jangan instal Filament Shield karena versi stabil Shield belum cocok dengan kombinasi Filament 5 + Spatie Permission 8.

Jika perintah instalasi Shield sempat gagal, project tetap aman karena Composer menampilkan:

```text
Installation failed, reverting ./composer.json and ./composer.lock
```

Artinya Shield belum terpasang dan tidak perlu menjalankan `composer remove bezhansalleh/filament-shield`.

Tambahkan trait Spatie pada model `app/Models/User.php`:

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    // ...
}
```

### 3. Konfigurasi Database

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

### 4. Membuat Model, Migration, dan Factory

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

### 5. Membuat Migration Komponen Database

```bash
php artisan make:migration create_siroma_views
php artisan make:migration create_siroma_stored_procedures
php artisan make:migration create_siroma_triggers
```

Urutan migration:

```text
Tabel -> Index -> View -> Stored Procedure -> Trigger
```

### 6. Menjalankan Migration

Jalankan setelah seluruh migration selesai:

```bash
php artisan migrate --pretend # untuk melihat query SQL tanpa eksekusi
php artisan optimize:clear

php artisan migrate
php artisan migrate:status
```

Untuk mengulang database selama pengembangan:

```bash
php artisan migrate:fresh
```

### 7. Membuat Seeder

```bash
php artisan make:seeder RolePermissionSeeder
php artisan make:seeder UserSeeder
php artisan make:seeder SiromaSeeder
```

Isi `database/seeders/RolePermissionSeeder.php` untuk membuat role dan permission dasar:

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'view users',
            'manage users',
            'view organizations',
            'manage organizations',
            'view divisions',
            'manage divisions',
            'view recruitment periods',
            'manage recruitment periods',
            'view applications',
            'create applications',
            'review applications',
            'delete applications',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'web');
        }

        $admin = Role::findOrCreate('super_admin', 'web');
        $reviewer = Role::findOrCreate('reviewer', 'web');
        $applicant = Role::findOrCreate('applicant', 'web');

        $admin->syncPermissions(Permission::all());

        $reviewer->syncPermissions([
            'view organizations',
            'view divisions',
            'view recruitment periods',
            'view applications',
            'review applications',
        ]);

        $applicant->syncPermissions([
            'view organizations',
            'view divisions',
            'view recruitment periods',
            'view applications',
            'create applications',
        ]);
    }
}
```

Panggil seeder tersebut dari `database/seeders/DatabaseSeeder.php`:

```php
public function run(): void
{
    $this->call([
        RolePermissionSeeder::class,
    ]);
}
```

Jalankan:

```bash
php artisan db:seed
```

Atau:

```bash
php artisan migrate:fresh --seed
```

### 8. Membuat Filament Resource

```bash
php artisan make:filament-resource User --generate
php artisan make:filament-resource Organization --generate
php artisan make:filament-resource Division --generate
php artisan make:filament-resource RecruitmentPeriod --generate
php artisan make:filament-resource Application --generate
```

Atur pembatasan akses resource langsung memakai permission Spatie, misalnya melalui policy, gate, atau method authorization pada resource Filament. Permission dibuat dan dikelola oleh `RolePermissionSeeder`, bukan oleh Shield.

### 9. Storage dan Menjalankan Project

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
