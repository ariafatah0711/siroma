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
        DB::table('organizations')->insert([
            [
                'id' => 1,
                'organization_code' => 'BEM-UNI',
                'organization_name' => 'Badan Eksekutif Mahasiswa Universitas',
                'description' => 'Organisasi eksekutif mahasiswa tingkat universitas.',
                'contact_email' => 'bem@kampus.ac.id',
                'contact_phone' => '081234567890',
            ],
            [
                'id' => 2,
                'organization_code' => 'HIMSI',
                'organization_name' => 'Himpunan Mahasiswa Sistem Informasi',
                'description' => 'Organisasi mahasiswa Program Studi Sistem Informasi.',
                'contact_email' => 'himsi@kampus.ac.id',
                'contact_phone' => '081234567891',
            ],
        ]);

        DB::table('organization_members')->insert([
            ['id' => 1, 'organization_id' => 1, 'user_id' => 1, 'member_role' => 'chairperson', 'joined_at' => '2025-08-01', 'is_active' => true],
            ['id' => 2, 'organization_id' => 1, 'user_id' => 2, 'member_role' => 'recruitment_admin', 'joined_at' => '2025-08-01', 'is_active' => true],
            ['id' => 3, 'organization_id' => 2, 'user_id' => 2, 'member_role' => 'interviewer', 'joined_at' => '2025-09-01', 'is_active' => true],
        ]);

        DB::table('divisions')->insert([
            ['id' => 1, 'organization_id' => 1, 'division_name' => 'Hubungan Masyarakat', 'description' => 'Mengelola komunikasi dan hubungan eksternal.', 'is_active' => true],
            ['id' => 2, 'organization_id' => 1, 'division_name' => 'Pengembangan Sumber Daya Mahasiswa', 'description' => 'Mengelola pengembangan kapasitas mahasiswa.', 'is_active' => true],
            ['id' => 3, 'organization_id' => 1, 'division_name' => 'Kreatif dan Media', 'description' => 'Mengelola desain, dokumentasi, dan media sosial.', 'is_active' => true],
            ['id' => 4, 'organization_id' => 1, 'division_name' => 'Sosial Masyarakat', 'description' => 'Mengelola kegiatan sosial dan pengabdian masyarakat.', 'is_active' => true],
            ['id' => 5, 'organization_id' => 2, 'division_name' => 'Akademik', 'description' => 'Mengelola kegiatan akademik dan pelatihan.', 'is_active' => true],
            ['id' => 6, 'organization_id' => 2, 'division_name' => 'Riset dan Teknologi', 'description' => 'Mengelola kegiatan riset dan pengembangan teknologi.', 'is_active' => true],
            ['id' => 7, 'organization_id' => 2, 'division_name' => 'Komunikasi dan Informasi', 'description' => 'Mengelola publikasi dan informasi organisasi.', 'is_active' => true],
        ]);

        DB::table('recruitment_periods')->insert([
            [
                'id' => 1,
                'organization_id' => 1,
                'created_by' => 2,
                'recruitment_title' => 'Open Recruitment BEM 2026',
                'academic_year' => '2025/2026',
                'registration_start_date' => DB::raw('CURDATE() - INTERVAL 7 DAY'),
                'registration_end_date' => DB::raw('CURDATE() + INTERVAL 14 DAY'),
                'total_quota' => 20,
                'recruitment_status' => 'open',
                'description' => 'Penerimaan anggota baru BEM untuk periode kepengurusan 2026.',
            ],
            [
                'id' => 2,
                'organization_id' => 2,
                'created_by' => 2,
                'recruitment_title' => 'Open Recruitment HIMSI 2026',
                'academic_year' => '2025/2026',
                'registration_start_date' => DB::raw('CURDATE() - INTERVAL 5 DAY'),
                'registration_end_date' => DB::raw('CURDATE() + INTERVAL 10 DAY'),
                'total_quota' => 15,
                'recruitment_status' => 'open',
                'description' => 'Penerimaan anggota baru HIMSI untuk periode kepengurusan 2026.',
            ],
            [
                'id' => 3,
                'organization_id' => 1,
                'created_by' => 1,
                'recruitment_title' => 'Open Recruitment BEM 2025',
                'academic_year' => '2024/2025',
                'registration_start_date' => '2025-01-10',
                'registration_end_date' => '2025-01-31',
                'total_quota' => 18,
                'recruitment_status' => 'completed',
                'description' => 'Periode rekrutmen BEM yang telah selesai.',
            ],
        ]);

        $applications = [
            ['app_1', 3, 1, 1, 2, 'Saya ingin meningkatkan kemampuan komunikasi dan berkontribusi dalam kegiatan mahasiswa.'],
            ['app_2', 4, 1, 2, 3, 'Saya tertarik mengembangkan program kerja mahasiswa serta kemampuan desain dan publikasi.'],
            ['app_3', 5, 1, 1, 4, 'Saya ingin memperluas pengalaman organisasi dan terlibat dalam kegiatan sosial mahasiswa.'],
            ['app_4', 6, 1, 3, null, 'Saya memiliki minat pada bidang media kreatif dan ingin membantu publikasi kegiatan organisasi.'],
            ['app_5', 7, 2, 6, 5, 'Saya ingin mengembangkan kemampuan teknologi sekaligus berkontribusi pada kegiatan akademik HIMSI.'],
            ['app_6', 8, 2, 7, 5, 'Saya tertarik pada pengelolaan informasi organisasi dan ingin meningkatkan pengalaman kerja tim.'],
        ];

        foreach ($applications as [$variable, $userId, $recruitmentPeriodId, $firstDivisionId, $secondDivisionId, $motivation]) {
            DB::statement("SET @{$variable} = NULL");
            DB::statement('CALL `sp_submit_application`(?, ?, ?, ?, ?, @'.$variable.')', [
                $userId,
                $recruitmentPeriodId,
                $firstDivisionId,
                $secondDivisionId,
                $motivation,
            ]);
        }

        DB::statement(<<<'SQL'
            INSERT INTO `application_documents` (`application_id`, `document_type`, `original_file_name`, `file_path`)
            VALUES
                (@app_1, 'cv', 'CV_Budi_Santoso.pdf', '/uploads/applications/budi/cv.pdf'),
                (@app_1, 'certificate', 'Sertifikat_Budi.pdf', '/uploads/applications/budi/sertifikat.pdf'),
                (@app_2, 'cv', 'CV_Citra_Lestari.pdf', '/uploads/applications/citra/cv.pdf'),
                (@app_2, 'portfolio', 'Portofolio_Citra.pdf', '/uploads/applications/citra/portofolio.pdf'),
                (@app_3, 'cv', 'CV_Dimas_Saputra.pdf', '/uploads/applications/dimas/cv.pdf'),
                (@app_4, 'portfolio', 'Portofolio_Eka.pdf', '/uploads/applications/eka/portofolio.pdf'),
                (@app_5, 'cv', 'CV_Farhan_Akbar.pdf', '/uploads/applications/farhan/cv.pdf'),
                (@app_5, 'certificate', 'Sertifikat_Farhan.pdf', '/uploads/applications/farhan/sertifikat.pdf'),
                (@app_6, 'cv', 'CV_Gita_Maharani.pdf', '/uploads/applications/gita/cv.pdf')
        SQL);

        DB::statement('CALL `sp_update_application_status`(@app_1, ?, ?, ?)', [
            'accepted',
            88.50,
            'Komunikasi baik dan sesuai dengan kebutuhan divisi.',
        ]);
        DB::statement('CALL `sp_update_application_status`(@app_2, ?, ?, ?)', [
            'rejected',
            72.00,
            'Kemampuan cukup baik, tetapi belum memenuhi kebutuhan divisi.',
        ]);
        DB::statement('CALL `sp_update_application_status`(@app_3, ?, ?, ?)', [
            'under_review',
            null,
            'Dokumen telah diperiksa dan menunggu penilaian akhir.',
        ]);
        DB::statement('CALL `sp_update_application_status`(@app_5, ?, ?, ?)', [
            'accepted',
            91.00,
            'Kemampuan teknis dan motivasi sangat sesuai.',
        ]);
        DB::statement('CALL `sp_update_application_status`(@app_6, ?, ?, ?)', [
            'withdrawn',
            null,
            'Pendaftar mengundurkan diri dari proses seleksi.',
        ]);
    }
}
