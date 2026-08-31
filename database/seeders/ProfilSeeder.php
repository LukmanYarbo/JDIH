<?php

namespace Database\Seeders;

use App\Models\Profil;
use Illuminate\Database\Seeder;

class ProfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profil::updateOrCreate(
            ['id' => 1],
            [
                'nama_kantor' => 'Dewan Perwakilan Rakyat Daerah Kabupaten Bolaang Mongondow Utara',
                'nama_singkat_kantor' => 'DPRD Kabupaten Bolaang Mongondow Utara',
                'nama_wilayah' => 'KABUPATEN BOLAANG MONGONDOW UTARA',
                'nama_sekretariat' => 'Sekretariat DPRD Kabupaten Bolaang Mongondow Utara',
                'welcome_title' => 'JARINGAN DOKUMENTASI DAN INFORMASI HUKUM',
                'welcome_subtitle' => 'DEWAN PERWAKILAN RAKYAT DAERAH KABUPATEN BOLAANG MONGONDOW UTARA',
                'visi' => "Terwujudnya Jaringan Dokumentasi dan Informasi Hukum DPRD yang Terintegrasi, Modern, Transparan, Akurat, dan Terpercaya dalam Mendukung Tata Kelola Pemerintahan yang Baik (Good Governance).",
                'misi' => "1. Menjamin ketersediaan dokumentasi dan informasi hukum yang lengkap, sahih, dan mutakhir.\n2. Mengembangkan sistem pelayanan informasi hukum berbasis teknologi informasi terintegrasi dengan JDIHN Nasional.\n3. Meningkatkan kualitas pengelolaan dan sumber daya manusia pengelola JDIH secara profesional.\n4. Meningkatkan partisipasi dan literasi hukum masyarakat melalui penyebarluasan produk hukum daerah secara mudah dan cepat.",
                'sejarah' => "Ide membentuk Jaringan Dokumentasi dan Informasi Hukum Nasional (JDIHN), secara historis melekat erat dengan pembangunan hukum nasional dalam upaya mewujudkan supremasi hukum. JDIH DPRD hadir sebagai pusat pangkalan data perundang-undangan dan instrumen dokumentasi hukum yang melayani pimpinan dewan, anggota dewan, aparatur sipil negara, akademisi, serta seluruh lapisan masyarakat luas.",
                'dasar_hukum' => "1. Peraturan Presiden Nomor 33 Tahun 2012 tentang Jaringan Dokumentasi dan Informasi Hukum Nasional.\n2. Peraturan Menteri Hukum dan Hak Asasi Manusia Nomor 8 Tahun 2019 tentang Standar Pengelolaan Dokumen dan Informasi Hukum.\n3. Peraturan Menteri Dalam Negeri Nomor 2 Tahun 2014 tentang Pengelolaan Jaringan Dokumentasi dan Informasi Hukum Kementerian Dalam Negeri dan Pemerintah Daerah.\n4. Peraturan Daerah tentang Pembentukan Peraturan Daerah dan Tata Tertib DPRD.",
                'sk_tim' => "Pengelolaan JDIH DPRD dilaksanakan berdasarkan Keputusan Sekretaris Dewan Perwakilan Rakyat Daerah tentang Pembentukan Tim Pengelola Jaringan Dokumentasi dan Informasi Hukum (JDIH) di Lingkungan Sekretariat DPRD, yang terdiri dari Pengarah, Penanggung Jawab, Ketua Tim, Koordinator Pengumpulan Dokumen, Verifikator Hukum, Pengolah Data Teknis, dan Administrator IT.",
                'sop' => "Standar Operasional Prosedur (SOP) JDIH DPRD meliputi:\n1. SOP Pengumpulan dan Inventarisasi Dokumen Hukum (Perda, Per-DPRD, Kep-DPRD, Risalah, Naskah Akademik).\n2. SOP Pengolahan, Pembuatan Abstrak, dan Verifikasi Materi Muatan Hukum.\n3. SOP Digitalisasi, Upload, dan Pemeliharaan Basis Data Portal JDIH.\n4. SOP Pelayanan Permintaan Informasi dan Salinan Produk Hukum kepada Pemohon/Masyarakat Publik.\n5. SOP Evaluasi, Pemutakhiran Status Peraturan, dan Integrasi API ke Portal JDIHN BPHN Kemenkumham.",
                'maklumat_pelayanan' => "Dengan ini kami menyatakan sanggup menyelenggarakan pelayanan informasi hukum publik sesuai standar pelayanan yang telah ditetapkan, dan apabila tidak menepati janji ini, kami siap menerima sanksi sesuai ketentuan peraturan perundang-undangan yang berlaku.",
                'jam_operasional' => "Senin - Kamis: 08.00 - 16.00 WIB | Jumat: 08.00 - 16.30 WIB",
                'alamat' => "Gedung DPRD, Bagian Persidangan & Perundang-Undangan Sekretariat DPRD Kota Medan, Jl. Kapten Maulana Lubis No. 1.",
                'telepon' => "061-4537728",
                'email' => "jdih@dprd.medan.go.id",
                'whatsapp' => "+62614537728",
                'facebook' => "https://www.facebook.com/sekretariat.dprdmedan.3",
                'instagram' => "https://www.instagram.com/humasdprdkotamedan/",
                'youtube' => "https://www.youtube.com/channel/UCQozcUiMTsOe4w5TL8UzLwQ",
                'twitter' => "https://twitter.com/dprdmedan1",
            ]
        );
    }
}
