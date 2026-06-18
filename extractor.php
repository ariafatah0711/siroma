<?php
/**
 * SIROMA Auto-Extractor Script
 * Digunakan untuk mengekstrak project.zip otomatis via CI/CD GitHub Actions
 */

$zipFile = 'project.zip';
$extractTo = './';

// Set header biar outputnya rapi saat ditembak sama curl GitHub Actions
header('Content-Type: text/plain');

if (file_exists($zipFile)) {
    $zip = new ZipArchive;
    if ($zip->open($zipFile) === TRUE) {
        // Proses ekstraksi file
        $zip->extractTo($extractTo);
        $zip->close();

        // Hapus file zip lama biar gak menuh-menuhin kuota hosting InfinityFree
        unlink($zipFile);

        echo "MANTAP BRE! Semua file berhasil diekstrak otomatis via CI/CD.";
    } else {
        echo "ERROR: Gagal membuka file project.zip, coba cek permission folder.";
    }
} else {
    echo "ERROR: File project.zip gak nemu di server. Cek lagi proses upload FTP di GitHub Actions.";
}
