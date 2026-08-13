<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed video items
        \App\Models\Galeri::create([
            'judul' => 'Rapat Paripurna DPRD Pembahasan Ranperda Tata Ruang Wilayah',
            'tipe' => 'video',
            'video_url' => 'https://www.youtube.com/embed/tgbNymZ7vqY',
            'keterangan' => 'Rapat Paripurna Dewan Perwakilan Rakyat Daerah (DPRD) Kabupaten Bolaang Mongondow Utara.',
        ]);

        \App\Models\Galeri::create([
            'judul' => 'Kunjungan Kerja Komisi I DPRD Bolmut ke DPRD Provinsi Sulawesi Utara',
            'tipe' => 'video',
            'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'keterangan' => 'Koordinasi dan konsultasi antarlembaga legislatif daerah terkait penguatan pengawasan pembangunan.',
        ]);

        // Seed photo items (pointing to generated files)
        \App\Models\Galeri::create([
            'judul' => 'Sosialisasi Perda Nomor 1 Tahun 2026 di Kecamatan Kaidipang',
            'tipe' => 'foto',
            'file_path' => 'uploads/gallery/photo1.jpg',
            'keterangan' => 'Sosialisasi produk hukum teranyar DPRD Kabupaten Bolaang Mongondow Utara kepada tokoh masyarakat.',
        ]);

        \App\Models\Galeri::create([
            'judul' => 'Pelantikan Anggota BPD se-Kabupaten Bolaang Mongondow Utara',
            'tipe' => 'foto',
            'file_path' => 'uploads/gallery/photo2.jpg',
            'keterangan' => 'Dokumentasi acara resmi pelantikan Badan Permusyawaratan Desa oleh Bupati dan Pimpinan DPRD.',
        ]);
    }
}
