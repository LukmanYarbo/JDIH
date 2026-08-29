<?php

namespace Database\Seeders;

use App\Models\Ranperda;
use Illuminate\Database\Seeder;

class RanperdaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ranperdas = [
            [
                'tahun' => 2026,
                'nomor_propemperda' => 'PROP-01/2026',
                'judul' => 'Rancangan Peraturan Daerah tentang Penghormatan Terhadap Rumah Ibadah dan Pemuka Agama',
                'pemrakarsa' => 'Inisiatif DPRD',
                'tahap_terakhir' => 4, // Pembahasan Pansus
                'status' => 'Dalam Pembahasan',
                'keterangan' => 'Sedang dalam pembahasan pasal demi pasal bersama perwakilan asosiasi keagamaan dan bagian hukum.',
                'hits' => 3420,
            ],
            [
                'tahun' => 2026,
                'nomor_propemperda' => 'PROP-02/2026',
                'judul' => 'Rancangan Peraturan Daerah tentang Pembangunan dan Ketahanan Keluarga',
                'pemrakarsa' => 'Pemerintah Daerah',
                'tahap_terakhir' => 3, // Harmonisasi
                'status' => 'Dalam Pembahasan',
                'keterangan' => 'Dalam proses harmonisasi dan sinkronisasi di Kementerian Hukum dan HAM Kanwil.',
                'hits' => 2890,
            ],
            [
                'tahun' => 2026,
                'nomor_propemperda' => 'PROP-03/2026',
                'judul' => 'Rancangan Peraturan Daerah tentang Perubahan Atas Peraturan Daerah Nomor 4 Tahun 2012 tentang Sistem Kesehatan Daerah',
                'pemrakarsa' => 'Inisiatif DPRD',
                'tahap_terakhir' => 5, // Paripurna / Persetujuan
                'status' => 'Disetujui',
                'keterangan' => 'Telah disetujui dalam rapat paripurna dan diajukan untuk evaluasi Gubernur.',
                'hits' => 4150,
            ],
            [
                'tahun' => 2026,
                'nomor_propemperda' => 'PROP-04/2026',
                'judul' => 'Rancangan Peraturan Daerah tentang Perubahan Atas Peraturan Daerah Nomor 5 Tahun 2015 tentang Penanggulangan Kemiskinan',
                'pemrakarsa' => 'Inisiatif DPRD',
                'tahap_terakhir' => 2, // Naskah Akademik
                'status' => 'Dalam Pembahasan',
                'keterangan' => 'Penyusunan naskah akademik dan uji publik bersama perguruan tinggi.',
                'hits' => 1980,
            ],
            [
                'tahun' => 2026,
                'nomor_propemperda' => 'PROP-05/2026',
                'judul' => 'Rancangan Peraturan Daerah tentang Pengarusutamaan Gender',
                'pemrakarsa' => 'Pemerintah Daerah',
                'tahap_terakhir' => 6, // Fasilitasi Kemendagri / Gubernur
                'status' => 'Dalam Pembahasan',
                'keterangan' => 'Menunggu surat hasil fasilitasi dari biro hukum provinsi.',
                'hits' => 3120,
            ],
            [
                'tahun' => 2025,
                'nomor_propemperda' => 'PROP-06/2025',
                'judul' => 'Rancangan Peraturan Daerah tentang Pajak Daerah dan Retribusi Daerah',
                'pemrakarsa' => 'Pemerintah Daerah',
                'tahap_terakhir' => 7, // Penetapan & Pengundangan
                'status' => 'Ditetapkan',
                'keterangan' => 'Telah disahkan dan diundangkan menjadi Peraturan Daerah.',
                'hits' => 6700,
            ],
        ];

        foreach ($ranperdas as $r) {
            Ranperda::create($r);
        }
    }
}
