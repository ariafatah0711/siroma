<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'id' => 1,
                'student_number' => '00000001',
                'full_name' => 'Super Admin',
                'email' => 'admin@localhost',
                'password_hash' => Hash::make('password'),
                'phone' => '081234560001',
                'faculty' => 'Direktorat IT',
                'study_program' => 'Infrastruktur',
                'entry_year' => 2022,
                'is_active' => true,
            ],
            [
                'id' => 2,
                'student_number' => '00000002',
                'full_name' => 'Reviewer BEM',
                'email' => 'bem@localhost',
                'password_hash' => Hash::make('password'),
                'phone' => '081234560002',
                'faculty' => 'Fakultas Ilmu Komputer',
                'study_program' => 'Sistem Informasi',
                'entry_year' => 2023,
                'is_active' => true,
            ],
            [
                'id' => 3,
                'student_number' => '00000003',
                'full_name' => 'Reviewer HIMA TI',
                'email' => 'hima@localhost',
                'password_hash' => Hash::make('password'),
                'phone' => '081234560003',
                'faculty' => 'Fakultas Ilmu Komputer',
                'study_program' => 'Informatika',
                'entry_year' => 2023,
                'is_active' => true,
            ],
            [
                'id' => 4,
                'student_number' => '00000004',
                'full_name' => 'Reviewer NFCC',
                'email' => 'nfcc@localhost',
                'password_hash' => Hash::make('password'),
                'phone' => '081234560004',
                'faculty' => 'Fakultas Ilmu Komputer',
                'study_program' => 'Informatika',
                'entry_year' => 2023,
                'is_active' => true,
            ],
            [
                'id' => 5,
                'student_number' => '24010001',
                'full_name' => 'aria',
                'email' => 'aria@localhost',
                'password_hash' => Hash::make('password'),
                'phone' => '081234560005',
                'faculty' => 'Fakultas Ilmu Komputer',
                'study_program' => 'Informatika',
                'entry_year' => 2024,
                'is_active' => true,
            ],
        ]);

        // Assign Spatie Roles to seeded users
        $superAdmin = User::find(1);
        if ($superAdmin) {
            $superAdmin->assignRole('super_admin');
        }

        foreach ([2, 3, 4] as $reviewerId) {
            $reviewer = User::find($reviewerId);
            if ($reviewer) {
                $reviewer->assignRole('reviewer');
            }
        }

        $aria = User::find(5);
        if ($aria) {
            $aria->assignRole('applicant');
        }
    }
}
