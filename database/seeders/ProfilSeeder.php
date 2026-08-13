<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Profil::create([
            'visi' => "Terwujudnya DPRD Kabupaten Bolaang Mongondow Utara sebagai Lembaga Perwakilan Rakyat yang Modern, Aspiratif, Transparan dan Akuntabel dalam Pengabdian kepada Masyarakat, Bangsa dan Negara.",
            'misi' => "1. Meningkatkan kualitas fungsi legislasi dalam pembentukan Peraturan Daerah.\n2. Mengoptimalkan fungsi anggaran yang berpihak pada kemakmuran rakyat.\n3. Meningkatkan pengawasan secara konsisten dan konstruktif terhadap jalannya pemerintahan daerah.\n4. Memperkuat saluran aspirasi masyarakat dalam perumusan kebijakan pembangunan.",
            'sejarah' => "Dewan Perwakilan Rakyat Daerah Kabupaten Bolaang Mongondow Utara dibentuk seiring dengan pemekaran Kabupaten Bolaang Mongondow Utara sebagai Daerah Otonom Baru pada tahun 2007 berdasarkan Undang-Undang Nomor 10 Tahun 2007. Sejak saat itu, DPRD Bolmut terus berkomitmen menyuarakan aspirasi rakyat Bolmut.",
            'alamat' => "Jl. Trans Sulawesi, Boroko, Kab. Bolaang Mongondow Utara, Sulawesi Utara.",
            'telepon' => "(0434) 123456",
            'email' => "sekretariat@dprd-bolmutkab.go.id",
            'struktur_organisasi' => null,
            'logo' => null,
        ]);
    }
}
