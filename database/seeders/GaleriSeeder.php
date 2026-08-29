<?php

namespace Database\Seeders;

use App\Models\Galeri;
use Illuminate\Database\Seeder;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'judul' => 'Rapat Paripurna DPRD Pembahasan Ranperda Tata Ruang Wilayah',
                'tipe' => 'video',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'keterangan' => 'Rapat Paripurna Dewan Perwakilan Rakyat Daerah (DPRD) pembahasan regulasi tata ruang wilayah kota.',
            ],
            [
                'judul' => 'Pelaksanaan Bimbingan Teknis & Pengelolaan JDIH Terpadu',
                'tipe' => 'video',
                'video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
                'keterangan' => 'Workshop peningkatan kapasitas operator dan pengelola perpustakaan hukum digital JDIH.',
            ],
            [
                'judul' => 'Sosialisasi Peraturan Daerah Kawasan Tanpa Rokok',
                'tipe' => 'foto',
                'file_path' => null,
                'keterangan' => 'Sosialisasi produk hukum teranyar kepada tokoh masyarakat, pemuda, dan tenaga kesehatan.',
            ],
            [
                'judul' => 'Rapat Dengar Pendapat Umum (RDPU) Bersama Komisi dan Warga',
                'tipe' => 'foto',
                'file_path' => null,
                'keterangan' => 'Mendengarkan aspirasi dan masukan penyusunan regulasi perlindungan sosial.',
            ],
        ];

        foreach ($items as $item) {
            Galeri::updateOrCreate(
                ['judul' => $item['judul']],
                $item
            );
        }
    }
}
