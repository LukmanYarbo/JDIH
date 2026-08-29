<?php

namespace Database\Seeders;

use App\Models\Buletin;
use Illuminate\Database\Seeder;

class BuletinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buletins = [
            [
                'edisi' => 'EDISI JAN-JUN 2026',
                'tahun' => 2026,
                'judul' => 'Buletin JDIH: Transformasi Digital Legislasi & Penguatan Fungsi Pengawasan',
                'deskripsi' => 'Memuat ulasan produk hukum semester 1 tahun 2026, ringkasan ranperda prioritas, dan opini hukum pakar tata negara.',
                'downloads' => 145,
            ],
            [
                'edisi' => 'EDISI JAN-JUN 2025',
                'tahun' => 2025,
                'judul' => 'Buletin JDIH: Sinergi Regulasi Daerah Mendukung Pertumbuhan Ekonomi',
                'deskripsi' => 'Kajian dampak regulasi retribusi daerah dan perlindungan ketenagakerjaan sektor informal.',
                'downloads' => 312,
            ],
            [
                'edisi' => 'RANGKUMAN 2024',
                'tahun' => 2024,
                'judul' => 'Rangkuman Tahunan JDIH: Refleksi Produk Hukum & Capaian Legislasi',
                'deskripsi' => 'Kompilasi seluruh Perda, Keputusan DPRD, dan telaahan naskah akademik sepanjang tahun sidang 2024.',
                'downloads' => 528,
            ],
            [
                'edisi' => 'RANGKUMAN 2023',
                'tahun' => 2023,
                'judul' => 'Rangkuman Produk Hukum & Kebijakan Publik Tahunan',
                'deskripsi' => 'Dokumentasi lengkap regulasi daerah pasca pandemi dan optimalisasi pendapatan asli daerah.',
                'downloads' => 410,
            ],
        ];

        foreach ($buletins as $b) {
            Buletin::create($b);
        }
    }
}
