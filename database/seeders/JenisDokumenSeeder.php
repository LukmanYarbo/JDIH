<?php

namespace Database\Seeders;

use App\Models\JenisDokumen;
use Illuminate\Database\Seeder;

class JenisDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // 1. PRODUK HUKUM
            [
                'tipe_dokumen' => 'Produk Hukum',
                'nama' => 'Peraturan Daerah',
                'kode' => 'PERDA',
                'deskripsi' => 'Peraturan Perundang-undangan yang dibentuk oleh DPRD dengan persetujuan bersama Kepala Daerah.',
                'urutan' => 1,
                'icon' => 'bi-journal-bookmark-fill',
            ],
            [
                'tipe_dokumen' => 'Produk Hukum',
                'nama' => 'Peraturan Kepala Daerah / Walikota',
                'kode' => 'PERWAL',
                'deskripsi' => 'Peraturan yang ditetapkan oleh Kepala Daerah guna menjalankan Peraturan Daerah.',
                'urutan' => 2,
                'icon' => 'bi-file-earmark-text',
            ],
            [
                'tipe_dokumen' => 'Produk Hukum',
                'nama' => 'Keputusan Dewan Perwakilan Rakyat Daerah',
                'kode' => 'KEP-DPRD',
                'deskripsi' => 'Keputusan resmi yang dikeluarkan oleh Dewan Perwakilan Rakyat Daerah.',
                'urutan' => 3,
                'icon' => 'bi-patch-check-fill',
            ],
            [
                'tipe_dokumen' => 'Produk Hukum',
                'nama' => 'Peraturan Dewan Perwakilan Rakyat Daerah',
                'kode' => 'PER-DPRD',
                'deskripsi' => 'Peraturan internal tata tertib dan tata beracara DPRD.',
                'urutan' => 4,
                'icon' => 'bi-file-earmark-person',
            ],
            [
                'tipe_dokumen' => 'Produk Hukum',
                'nama' => 'Keputusan Pimpinan DPRD',
                'kode' => 'KEP-PIM-DPRD',
                'deskripsi' => 'Keputusan yang ditetapkan oleh Pimpinan DPRD dalam hal tertentu sesuai kewenangan.',
                'urutan' => 5,
                'icon' => 'bi-award-fill',
            ],
            [
                'tipe_dokumen' => 'Produk Hukum',
                'nama' => 'Keputusan Sekretaris DPRD',
                'kode' => 'KEP-SEKWAN',
                'deskripsi' => 'Keputusan yang diterbitkan oleh Sekretaris DPRD mengenai administrasi dan teknis operasional.',
                'urutan' => 6,
                'icon' => 'bi-person-badge',
            ],
            [
                'tipe_dokumen' => 'Produk Hukum',
                'nama' => 'Surat Edaran',
                'kode' => 'SE',
                'deskripsi' => 'Naskah dinas yang memuat pemberitahuan atau petunjuk pelaksanaan kebijakan.',
                'urutan' => 7,
                'icon' => 'bi-envelope-paper',
            ],
            [
                'tipe_dokumen' => 'Produk Hukum',
                'nama' => 'Persetujuan Bersama Kepala Daerah & DPRD',
                'kode' => 'PERSETUJUAN-BERSAMA',
                'deskripsi' => 'Dokumen persetujuan bersama antara Kepala Daerah dan DPRD atas Ranperda/Kebijakan Strategis.',
                'urutan' => 8,
                'icon' => 'bi-hand-thumbs-up',
            ],
            [
                'tipe_dokumen' => 'Produk Hukum',
                'nama' => 'MoU (Nota Kesepahaman)',
                'kode' => 'MOU',
                'deskripsi' => 'Nota kesepahaman kemitraan kelembagaan dan kerjasama antar instansi.',
                'urutan' => 9,
                'icon' => 'bi-file-earmark-diff',
            ],
            [
                'tipe_dokumen' => 'Produk Hukum',
                'nama' => 'Perjanjian Kerja Sama',
                'kode' => 'PKS',
                'deskripsi' => 'Perjanjian operasional teknis tindak lanjut nota kesepahaman.',
                'urutan' => 10,
                'icon' => 'bi-briefcase',
            ],

            // 2. MONOGRAFI HUKUM
            [
                'tipe_dokumen' => 'Monografi Hukum',
                'nama' => 'Rancangan Peraturan Daerah',
                'kode' => 'RANPERDA',
                'deskripsi' => 'Draf rancangan peraturan daerah yang sedang dalam proses legislasi.',
                'urutan' => 11,
                'icon' => 'bi-file-earmark-richtext',
            ],
            [
                'tipe_dokumen' => 'Monografi Hukum',
                'nama' => 'Naskah Akademik',
                'kode' => 'NA',
                'deskripsi' => 'Naskah hasil penelitian atau pengkajian hukum sebagai landasan ilmiah pembentukan Ranperda.',
                'urutan' => 12,
                'icon' => 'bi-book-half',
            ],
            [
                'tipe_dokumen' => 'Monografi Hukum',
                'nama' => 'Risalah Rapat',
                'kode' => 'RISALAH',
                'deskripsi' => 'Catatan lengkap jalannya rapat paripurna atau rapat pansus DPRD kata demi kata.',
                'urutan' => 13,
                'icon' => 'bi-card-list',
            ],
            [
                'tipe_dokumen' => 'Monografi Hukum',
                'nama' => 'Koleksi Buku',
                'kode' => 'BUKU',
                'deskripsi' => 'Buku-buku referensi hukum, tata negara, dan pemerintahan perpustakaan JDIH.',
                'urutan' => 14,
                'icon' => 'bi-journal-album',
            ],
            [
                'tipe_dokumen' => 'Monografi Hukum',
                'nama' => 'Hasil Harmonisasi',
                'kode' => 'HARMONISASI',
                'deskripsi' => 'Berita acara dan telaah hasil pengharmonisasian, pembulatan, dan pemantapan konsepsi Ranperda.',
                'urutan' => 15,
                'icon' => 'bi-check2-circle',
            ],
            [
                'tipe_dokumen' => 'Monografi Hukum',
                'nama' => 'Evaluasi / Fasilitasi Ranperda',
                'kode' => 'FASILITASI',
                'deskripsi' => 'Hasil fasilitasi atau evaluasi Gubernur/Kemendagri terhadap Ranperda sebelum diundangkan.',
                'urutan' => 16,
                'icon' => 'bi-clipboard-check',
            ],
            [
                'tipe_dokumen' => 'Monografi Hukum',
                'nama' => 'Rancangan Peraturan DPRD',
                'kode' => 'RANPER-DPRD',
                'deskripsi' => 'Draf usulan rancangan peraturan internal DPRD.',
                'urutan' => 17,
                'icon' => 'bi-file-earmark-ruled',
            ],
            [
                'tipe_dokumen' => 'Monografi Hukum',
                'nama' => 'Analisis dan Evaluasi',
                'kode' => 'ANEV',
                'deskripsi' => 'Hasil analisis dan evaluasi efektivitas produk hukum yang telah berlaku.',
                'urutan' => 18,
                'icon' => 'bi-graph-up-arrow',
            ],
            [
                'tipe_dokumen' => 'Monografi Hukum',
                'nama' => 'Kajian/Telaahan Staf',
                'kode' => 'TELAAHAN',
                'deskripsi' => 'Kajian teknis dan telaahan staf bagian perundang-undangan.',
                'urutan' => 19,
                'icon' => 'bi-search',
            ],
            [
                'tipe_dokumen' => 'Monografi Hukum',
                'nama' => 'Notulen',
                'kode' => 'NOTULEN',
                'deskripsi' => 'Ringkasan hasil rapat kerja, rapat dengar pendapat (RDP), dan konsultasi.',
                'urutan' => 20,
                'icon' => 'bi-pen',
            ],
            [
                'tipe_dokumen' => 'Monografi Hukum',
                'nama' => 'Jadwal Acara Rapat DPRD',
                'kode' => 'JADWAL-RAPAT',
                'deskripsi' => 'Jadwal sidang, rapat paripurna, dan agenda kerja DPRD.',
                'urutan' => 21,
                'icon' => 'bi-calendar-event',
            ],

            // 3. ARTIKEL HUKUM
            [
                'tipe_dokumen' => 'Artikel Hukum',
                'nama' => 'Artikel Ilmiah',
                'kode' => 'ARTIKEL-ILMIAH',
                'deskripsi' => 'Karya tulis ilmiah bidang hukum dan perundang-undangan.',
                'urutan' => 22,
                'icon' => 'bi-mortarboard',
            ],
            [
                'tipe_dokumen' => 'Artikel Hukum',
                'nama' => 'Kliping Koran',
                'kode' => 'KLIPING',
                'deskripsi' => 'Kliping berita dan opini media massa terkait isu hukum dan kedewanan.',
                'urutan' => 23,
                'icon' => 'bi-newspaper',
            ],
            [
                'tipe_dokumen' => 'Artikel Hukum',
                'nama' => 'Artikel Hukum',
                'kode' => 'ARTIKEL-HUKUM',
                'deskripsi' => 'Tulisan dan ulasan praktisi / akademisi hukum.',
                'urutan' => 24,
                'icon' => 'bi-file-text',
            ],
            [
                'tipe_dokumen' => 'Artikel Hukum',
                'nama' => 'Protokol',
                'kode' => 'PROTOKOL',
                'deskripsi' => 'Panduan dan protokol tata upacara dan persidangan.',
                'urutan' => 25,
                'icon' => 'bi-shield-check',
            ],
            [
                'tipe_dokumen' => 'Artikel Hukum',
                'nama' => 'Artikel Bahasa Inggris',
                'kode' => 'ARTIKEL-EN',
                'deskripsi' => 'Legal articles and international policy papers in English.',
                'urutan' => 26,
                'icon' => 'bi-translate',
            ],
            [
                'tipe_dokumen' => 'Artikel Hukum',
                'nama' => 'Piagam',
                'kode' => 'PIAGAM',
                'deskripsi' => 'Piagam penghargaan dan deklarasi kesepakatan bersama.',
                'urutan' => 27,
                'icon' => 'bi-award',
            ],
            [
                'tipe_dokumen' => 'Artikel Hukum',
                'nama' => 'Dokumen Langka',
                'kode' => 'DOKUMEN-LANGKA',
                'deskripsi' => 'Arsip naskah sejarah perundang-undangan masa lampau.',
                'urutan' => 28,
                'icon' => 'bi-archive',
            ],

            // 4. PUTUSAN PENGADILAN
            [
                'tipe_dokumen' => 'Putusan Pengadilan',
                'nama' => 'Putusan Mahkamah Agung',
                'kode' => 'PUTUSAN-MA',
                'deskripsi' => 'Putusan yurisprudensi dan uji materiil dari Mahkamah Agung Republik Indonesia.',
                'urutan' => 29,
                'icon' => 'bi-bank',
            ],
            [
                'tipe_dokumen' => 'Putusan Pengadilan',
                'nama' => 'Penetapan Pengadilan Negeri',
                'kode' => 'PENETAPAN-PN',
                'deskripsi' => 'Penetapan perdata atau hukum acara dari Pengadilan Negeri.',
                'urutan' => 30,
                'icon' => 'bi-file-earmark-check',
            ],
            [
                'tipe_dokumen' => 'Putusan Pengadilan',
                'nama' => 'Putusan Pengadilan Negeri',
                'kode' => 'PUTUSAN-PN',
                'deskripsi' => 'Salinan putusan perkara hukum dari Pengadilan Negeri.',
                'urutan' => 31,
                'icon' => 'bi-hammer',
            ],
            [
                'tipe_dokumen' => 'Putusan Pengadilan',
                'nama' => 'Putusan Pengadilan Tinggi',
                'kode' => 'PUTUSAN-PT',
                'deskripsi' => 'Salinan putusan tingkat banding dari Pengadilan Tinggi / PTUN.',
                'urutan' => 32,
                'icon' => 'bi-building-check',
            ],
        ];

        foreach ($categories as $cat) {
            JenisDokumen::updateOrCreate(
                ['kode' => $cat['kode']],
                $cat
            );
        }
    }
}
