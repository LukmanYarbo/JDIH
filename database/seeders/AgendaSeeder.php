<?php

namespace Database\Seeders;

use App\Models\Agenda;
use Illuminate\Database\Seeder;

class AgendaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agendas = [
            [
                'judul' => 'Pelaksanaan Rapat Kerja (Raker) DPRD dalam Rangka Penyusunan Program Kerja Tahun 2027',
                'waktu_mulai' => now()->addDays(2)->setHour(10)->setMinute(0),
                'waktu_selesai' => now()->addDays(2)->setHour(13)->setMinute(0),
                'lokasi' => 'Ruang Rapat Paripurna Gedung DPRD',
                'deskripsi' => 'Penyusunan kerangka kerja tahunan dan rencana pembahasan regulasi legislasi daerah.',
                'pelaksana' => 'Pimpinan & Seluruh Anggota DPRD',
                'status' => 'Akan Datang',
                'is_active_ticker' => true,
            ],
            [
                'judul' => 'Lanjutan Pembahasan KUA-PPAS P.APBD Tahun Anggaran 2026 bersama Tim Anggaran Pemerintah Daerah (TAPD)',
                'waktu_mulai' => now()->addDays(4)->setHour(10)->setMinute(0),
                'waktu_selesai' => now()->addDays(4)->setHour(16)->setMinute(0),
                'lokasi' => 'Ruang Badan Anggaran DPRD',
                'deskripsi' => 'Rapat pendalaman alokasi anggaran belanja prioritas dan pendapatan asli daerah.',
                'pelaksana' => 'Badan Anggaran (Banggar) & TAPD',
                'status' => 'Akan Datang',
                'is_active_ticker' => true,
            ],
            [
                'judul' => 'Rapat Paripurna: Pemandangan Umum Fraksi-Fraksi terhadap Ranperda Perubahan Lembaga Kemasyarakatan',
                'waktu_mulai' => now()->addDays(6)->setHour(10)->setMinute(0),
                'waktu_selesai' => now()->addDays(6)->setHour(12)->setMinute(30),
                'lokasi' => 'Ruang Rapat Paripurna Utama',
                'deskripsi' => 'Penyampaian pandangan umum dan masukan dari seluruh fraksi dewan.',
                'pelaksana' => 'Fraksi-Fraksi DPRD',
                'status' => 'Akan Datang',
                'is_active_ticker' => true,
            ],
            [
                'judul' => 'Rapat Dengar Pendapat (RDP) Komisi Terkait Pelayanan Kesehatan dan Fasilitas Rumah Sakit',
                'waktu_mulai' => now()->addDays(8)->setHour(14)->setMinute(0),
                'waktu_selesai' => now()->addDays(8)->setHour(17)->setMinute(0),
                'lokasi' => 'Ruang Rapat Komisi',
                'deskripsi' => 'Mendengarkan aspirasi publik dan konfirmasi dari dinas kesehatan terkait standar layanan rujukan.',
                'pelaksana' => 'Komisi DPRD & Dinas Kesehatan',
                'status' => 'Akan Datang',
                'is_active_ticker' => true,
            ],
            [
                'judul' => 'Sosialisasi Peraturan Daerah (Sosper) Kawasan Tanpa Rokok dan Ketertiban Umum',
                'waktu_mulai' => now()->addDays(10)->setHour(9)->setMinute(0),
                'waktu_selesai' => now()->addDays(10)->setHour(12)->setMinute(0),
                'lokasi' => 'Daerah Pemilihan (Dapil) 1 - 5',
                'deskripsi' => 'Penyebarluasan materi produk hukum daerah langsung kepada masyarakat luas.',
                'pelaksana' => 'Pimpinan & Anggota DPRD',
                'status' => 'Akan Datang',
                'is_active_ticker' => true,
            ],
        ];

        foreach ($agendas as $agenda) {
            Agenda::create($agenda);
        }
    }
}
