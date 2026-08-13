<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DokumenHukumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $perda = \App\Models\JenisDokumen::where('kode', 'PERDA')->first();
        $perDprd = \App\Models\JenisDokumen::where('kode', 'PER-DPRD')->first();
        $kepDprd = \App\Models\JenisDokumen::where('kode', 'KEP-DPRD')->first();

        if ($perda) {
            \App\Models\DokumenHukum::create([
                'jenis_dokumen_id' => $perda->id,
                'judul' => 'Anggaran Pendapatan dan Belanja Daerah Kabupaten Bolaang Mongondow Utara Tahun Anggaran 2026',
                'nomor' => '1',
                'tahun' => 2026,
                'tanggal_ditetapkan' => '2026-01-02',
                'file_pdf' => null,
                'abstrak' => 'Peraturan Daerah ini mengatur mengenai Anggaran Pendapatan dan Belanja Daerah (APBD) Kabupaten Bolaang Mongondow Utara untuk Tahun Anggaran 2026.',
                'status' => 'Berlaku',
                'hits' => 125,
            ]);
        }

        if ($perDprd) {
            \App\Models\DokumenHukum::create([
                'jenis_dokumen_id' => $perDprd->id,
                'judul' => 'Tata Tertib Dewan Perwakilan Rakyat Daerah Kabupaten Bolaang Mongondow Utara',
                'nomor' => '2',
                'tahun' => 2026,
                'tanggal_ditetapkan' => '2026-01-15',
                'file_pdf' => null,
                'abstrak' => 'Peraturan ini menetapkan tata tertib pelaksanaan tugas, wewenang, hak, dan kewajiban anggota DPRD Kabupaten Bolaang Mongondow Utara.',
                'status' => 'Berlaku',
                'hits' => 98,
            ]);
        }

        if ($kepDprd) {
            \App\Models\DokumenHukum::create([
                'jenis_dokumen_id' => $kepDprd->id,
                'judul' => 'Persetujuan atas Rancangan Peraturan Daerah tentang Rencana Pembangunan Jangka Panjang Daerah Tahun 2026-2046',
                'nomor' => '3',
                'tahun' => 2026,
                'tanggal_ditetapkan' => '2026-02-10',
                'file_pdf' => null,
                'abstrak' => 'Keputusan DPRD ini menyetujui rancangan peraturan daerah mengenai RPJPD Kabupaten Bolaang Mongondow Utara periode 2026-2046.',
                'status' => 'Berlaku',
                'hits' => 74,
            ]);
        }
    }
}
