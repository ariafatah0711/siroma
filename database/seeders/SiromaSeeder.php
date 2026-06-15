<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiromaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Organizations
        DB::table('organizations')->insert([
            [
                'id' => 1,
                'organization_code' => 'BEM',
                'organization_name' => 'Badan Eksekutif Mahasiswa',
                'description' => 'Organisasi eksekutif mahasiswa tingkat tinggi kampus.',
                'contact_email' => 'bem@localhost',
                'contact_phone' => '081234567890',
            ],
            [
                'id' => 2,
                'organization_code' => 'HIMA-TI',
                'organization_name' => 'Himpunan Mahasiswa Teknik Informatika',
                'description' => 'Organisasi kemahasiswaan untuk program studi Teknik Informatika.',
                'contact_email' => 'hima@localhost',
                'contact_phone' => '081234567891',
            ],
            [
                'id' => 3,
                'organization_code' => 'NFCC',
                'organization_name' => 'Nurul Fikri Cyber Security Community',
                'description' => 'Unit kegiatan mahasiswa yang fokus pada pembelajaran keamanan siber.',
                'contact_email' => 'nfcc@localhost',
                'contact_phone' => '081234567892',
            ],
        ]);

        // 2. Seed Organization Members (assigning reviewers to their respective organizations)
        DB::table('organization_members')->insert([
            [
                'id' => 1,
                'organization_id' => 1,
                'user_id' => 2, // bem@localhost
                'member_role' => 'recruitment_admin',
                'joined_at' => '2025-08-01',
                'is_active' => true
            ],
            [
                'id' => 2,
                'organization_id' => 2,
                'user_id' => 3, // hima@localhost
                'member_role' => 'recruitment_admin',
                'joined_at' => '2025-08-01',
                'is_active' => true
            ],
            [
                'id' => 3,
                'organization_id' => 3,
                'user_id' => 4, // nfcc@localhost
                'member_role' => 'recruitment_admin',
                'joined_at' => '2025-08-01',
                'is_active' => true
            ],
        ]);

        // 3. Seed Divisions
        DB::table('divisions')->insert([
            // BEM Divisions
            ['id' => 1, 'organization_id' => 1, 'division_name' => 'Hubungan Masyarakat', 'description' => 'Mengelola komunikasi dan hubungan eksternal.', 'is_active' => true],
            ['id' => 2, 'organization_id' => 1, 'division_name' => 'Pengembangan Sumber Daya Mahasiswa', 'description' => 'Mengelola pengembangan kapasitas mahasiswa.', 'is_active' => true],
            ['id' => 3, 'organization_id' => 1, 'division_name' => 'Kreatif dan Media', 'description' => 'Mengelola desain, dokumentasi, dan media sosial.', 'is_active' => true],
            ['id' => 4, 'organization_id' => 1, 'division_name' => 'Sosial Masyarakat', 'description' => 'Mengelola kegiatan sosial dan pengabdian masyarakat.', 'is_active' => true],

            // HIMA TI Divisions
            ['id' => 5, 'organization_id' => 2, 'division_name' => 'Pendidikan dan Pelatihan', 'description' => 'Mengelola kegiatan akademik dan pelatihan coding.', 'is_active' => true],
            ['id' => 6, 'organization_id' => 2, 'division_name' => 'Riset dan Teknologi', 'description' => 'Mengembangkan aplikasi dan riset siber mahasiswa.', 'is_active' => true],
            ['id' => 7, 'organization_id' => 2, 'division_name' => 'Hubungan Mahasiswa', 'description' => 'Menjembatani aspirasi mahasiswa Teknik Informatika.', 'is_active' => true],

            // NFCC Divisions
            ['id' => 8, 'organization_id' => 3, 'division_name' => 'Penetration Testing', 'description' => 'Pembelajaran teknik pentest aplikasi web, jaringan, dan sistem.', 'is_active' => true],
            ['id' => 9, 'organization_id' => 3, 'division_name' => 'Digital Forensics', 'description' => 'Analisis insiden siber, malware, dan pemulihan data.', 'is_active' => true],
            ['id' => 10, 'organization_id' => 3, 'division_name' => 'Security Operations', 'description' => 'Monitoring sistem pertahanan siber dan blue teaming.', 'is_active' => true],
        ]);

        // 4. Seed Recruitment Periods
        DB::table('recruitment_periods')->insert([
            [
                'id' => 1,
                'organization_id' => 1,
                'created_by' => 2, // bem@localhost
                'recruitment_title' => 'Open Recruitment BEM 2026',
                'academic_year' => '2025/2026',
                'registration_start_date' => DB::raw('CURDATE() - INTERVAL 1 DAY'),
                'registration_end_date' => DB::raw('CURDATE() + INTERVAL 14 DAY'),
                'total_quota' => 20,
                'recruitment_status' => 'open',
                'description' => 'Penerimaan anggota baru Badan Eksekutif Mahasiswa (BEM) periode 2026.',
            ],
            [
                'id' => 2,
                'organization_id' => 2,
                'created_by' => 3, // hima@localhost
                'recruitment_title' => 'Open Recruitment HIMA TI 2026',
                'academic_year' => '2025/2026',
                'registration_start_date' => DB::raw('CURDATE() - INTERVAL 1 DAY'),
                'registration_end_date' => DB::raw('CURDATE() + INTERVAL 14 DAY'),
                'total_quota' => 15,
                'recruitment_status' => 'open',
                'description' => 'Bergabunglah dengan Himpunan Mahasiswa Teknik Informatika (HIMA TI) 2026.',
            ],
            [
                'id' => 3,
                'organization_id' => 3,
                'created_by' => 4, // nfcc@localhost
                'recruitment_title' => 'Open Recruitment NF Cyber Security 2026',
                'academic_year' => '2025/2026',
                'registration_start_date' => DB::raw('CURDATE() - INTERVAL 1 DAY'),
                'registration_end_date' => DB::raw('CURDATE() + INTERVAL 14 DAY'),
                'total_quota' => 10,
                'recruitment_status' => 'open',
                'description' => 'Pendaftaran anggota baru Nurul Fikri Cyber Security Community (NFCC) 2026.',
            ],
        ]);

        // Note: No applications or documents seeded as per request, ensuring a clean slate.
    }
}
