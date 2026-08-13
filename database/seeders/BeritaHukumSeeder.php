<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BeritaHukumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::where('email', 'admin@gmail.com')->first();
        if (!$admin) {
            return;
        }

        \App\Models\BeritaHukum::create([
            'judul' => 'DPRD Bolaang Mongondow Utara Selenggarakan Rapat Paripurna LKPJ Bupati',
            'slug' => \Illuminate\Support\Str::slug('DPRD Bolaang Mongondow Utara Selenggarakan Rapat Paripurna LKPJ Bupati'),
            'konten' => 'Dewan Perwakilan Rakyat Daerah (DPRD) Kabupaten Bolaang Mongondow Utara menggelar Rapat Paripurna dalam rangka Penyampaian Laporan Keterangan Pertanggungjawaban (LKPJ) Bupati Bolaang Mongondow Utara Tahun Anggaran 2025. Rapat ini dipimpin oleh Ketua DPRD dan dihadiri oleh segenap jajaran anggota legislatif serta Forkopimda.',
            'gambar' => null,
            'user_id' => $admin->id,
        ]);

        \App\Models\BeritaHukum::create([
            'judul' => 'Sosialisasi Peraturan Daerah tentang Pengelolaan Sampah dan Lingkungan Hidup',
            'slug' => \Illuminate\Support\Str::slug('Sosialisasi Peraturan Daerah tentang Pengelolaan Sampah dan Lingkungan Hidup'),
            'konten' => 'Badan Pembentukan Peraturan Daerah (Bapemperda) DPRD Bolaang Mongondow Utara melaksanakan sosialisasi Perda tentang Pengelolaan Sampah kepada perwakilan masyarakat di berbagai kecamatan. Sosialisasi ini bertujuan meningkatkan pemahaman publik mengenai hak dan kewajiban dalam menjaga kelestarian lingkungan hidup.',
            'gambar' => null,
            'user_id' => $admin->id,
        ]);
    }
}
