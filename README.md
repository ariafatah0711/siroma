# Tugas Akhir Pemweb
## SIROMA (Sistem Informasi Rekrutmen Organisasi Mahasiswa)
- Nama aplikasi : SIROMA
- Repository    : siroma
- Database      : siroma_db

## Setup Awal
#### Install package, dan konfigurasi awal
```bash
# create project
composer create-project laravel/laravel siroma "12.*"

# install filament
composer require filament/filament:"~5.0"
php artisan filament:install --panels

# install spatie/laravel-permission
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
```

#### Membuat Model, Migration, dan Seeder untuk User
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

> -m = migration
-f = factory

```bash
# optimize clear, dan migrasi database
php artisan optimize:clear
php artisan migrate

# cek status migrasi
php artisan migrate:status

# storage link
php artisan storage:link
# Perintah storage:link diperlukan agar dokumen pada storage/app/public dapat diakses dari aplikasi.
```

#### Instalasi Filament Shield
```bash
composer require bezhansalleh/filament-shield
php artisan vendor:publish --tag="filament-shield-config"
php artisan shield:setup
```
