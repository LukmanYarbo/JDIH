<?php

namespace Database\Seeders;

use App\Models\BeritaHukum;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BeritaHukumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::where('email', 'admin@gmail.com')->first();
        if (!$admin) {
            return;
        }

        $news = [
            [
                'judul' => 'Pemandangan Umum Fraksi-Fraksi DPRD atas Penjelasan Kepala Daerah terhadap Ranperda Pencabutan Perda Lembaga Kemasyarakatan',
                'konten' => 'Dewan Perwakilan Rakyat Daerah menggelar Rapat Paripurna dengan agenda Pemandangan Umum Fraksi-Fraksi terhadap penjelasan Kepala Daerah mengenai Ranperda Pencabutan Perda Lembaga Kemasyarakatan. Seluruh fraksi memberikan apresiasi dan catatan konstruktif guna penyesuaian regulasi dengan peraturan perundang-undangan yang lebih tinggi.',
                'gambar' => null,
            ],
            [
                'judul' => 'Sekretariat DPRD Raih Penghargaan Pengelola JDIH Terbaik dan Terinovatif',
                'konten' => 'Sekretariat DPRD berhasil meraih penghargaan bergengsi sebagai salah satu Pengelola Jaringan Dokumentasi dan Informasi Hukum (JDIH) Terbaik Nasional. Penghargaan ini menjadi bukti komitmen berkelanjutan dalam keterbukaan informasi publik dan digitalisasi produk legislasi daerah.',
                'gambar' => null,
            ],
            [
                'judul' => 'Penyampaian Laporan Pansus DPRD tentang Peningkatan PAD dan Penertiban Aset Daerah',
                'konten' => 'Panitia Khusus (Pansus) DPRD menyampaikan laporan hasil kerja terkait optimalisasi Pendapatan Asli Daerah (PAD) dan Penertiban Aset Daerah. Hasil evaluasi dan rekomendasi strategis telah disepakati untuk dijadikan pedoman bersama dalam penataan aset publik.',
                'gambar' => null,
            ],
            [
                'judul' => 'Rapat Paripurna Penetapan Program Pembentukan Peraturan Daerah (Propemperda) Tahun 2026',
                'konten' => 'DPRD bersama Kepala Daerah secara resmi menetapkan daftar prioritas Program Pembentukan Peraturan Daerah (Propemperda) Tahun Sidang 2026 yang memuat sejumlah rancangan regulasi inisiatif dewan dan usulan eksekutif demi kesejahteraan masyarakat.',
                'gambar' => null,
            ],
        ];

        foreach ($news as $item) {
            $slug = Str::slug($item['judul']);
            BeritaHukum::updateOrCreate(
                ['slug' => $slug],
                [
                    'judul' => $item['judul'],
                    'konten' => $item['konten'],
                    'gambar' => $item['gambar'],
                    'user_id' => $admin->id,
                ]
            );
        }
    }
}
