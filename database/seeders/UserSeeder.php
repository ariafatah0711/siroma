<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
                'student_number' => '23010001',
                'full_name' => 'Andi Pratama',
                'email' => 'andi.pratama@student.ac.id',
                'password_hash' => Hash::make('andi123'),
                'phone' => '081234560001',
                'faculty' => 'Fakultas Ilmu Komputer',
                'study_program' => 'Sistem Informasi',
                'entry_year' => 2023,
                'is_active' => true,
            ],
            [
                'id' => 2,
                'student_number' => '23010002',
                'full_name' => 'Siti Rahma',
                'email' => 'siti.rahma@student.ac.id',
                'password_hash' => Hash::make('siti123'),
                'phone' => '081234560002',
                'faculty' => 'Fakultas Ilmu Komputer',
                'study_program' => 'Informatika',
                'entry_year' => 2023,
                'is_active' => true,
            ],
            [
                'id' => 3,
                'student_number' => '24010003',
                'full_name' => 'Budi Santoso',
                'email' => 'budi.santoso@student.ac.id',
                'password_hash' => Hash::make('budi123'),
                'phone' => '081234560003',
                'faculty' => 'Fakultas Ekonomi',
                'study_program' => 'Manajemen',
                'entry_year' => 2024,
                'is_active' => true,
            ],
            [
                'id' => 4,
                'student_number' => '24010004',
                'full_name' => 'Citra Lestari',
                'email' => 'citra.lestari@student.ac.id',
                'password_hash' => Hash::make('citra123'),
                'phone' => '081234560004',
                'faculty' => 'Fakultas Ilmu Komputer',
                'study_program' => 'Sistem Informasi',
                'entry_year' => 2024,
                'is_active' => true,
            ],
            [
                'id' => 5,
                'student_number' => '24010005',
                'full_name' => 'Dimas Saputra',
                'email' => 'dimas.saputra@student.ac.id',
                'password_hash' => Hash::make('dimas123'),
                'phone' => '081234560005',
                'faculty' => 'Fakultas Teknik',
                'study_program' => 'Teknik Industri',
                'entry_year' => 2024,
                'is_active' => true,
            ],
            [
                'id' => 6,
                'student_number' => '24010006',
                'full_name' => 'Eka Nuraini',
                'email' => 'eka.nuraini@student.ac.id',
                'password_hash' => Hash::make('eka123'),
                'phone' => '081234560006',
                'faculty' => 'Fakultas Ilmu Sosial',
                'study_program' => 'Ilmu Komunikasi',
                'entry_year' => 2024,
                'is_active' => true,
            ],
            [
                'id' => 7,
                'student_number' => '24010007',
                'full_name' => 'Farhan Akbar',
                'email' => 'farhan.akbar@student.ac.id',
                'password_hash' => Hash::make('farhan123'),
                'phone' => '081234560007',
                'faculty' => 'Fakultas Ilmu Komputer',
                'study_program' => 'Informatika',
                'entry_year' => 2024,
                'is_active' => true,
            ],
            [
                'id' => 8,
                'student_number' => '24010008',
                'full_name' => 'Gita Maharani',
                'email' => 'gita.maharani@student.ac.id',
                'password_hash' => Hash::make('gita123'),
                'phone' => '081234560008',
                'faculty' => 'Fakultas Ekonomi',
                'study_program' => 'Akuntansi',
                'entry_year' => 2024,
                'is_active' => true,
            ],
        ]);
    }
}
