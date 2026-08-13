<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisDokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\JenisDokumen::create([
            'nama' => 'Peraturan Daerah',
            'kode' => 'PERDA',
            'deskripsi' => 'Peraturan Daerah Kabupaten Bolaang Mongondow Utara',
        ]);

        \App\Models\JenisDokumen::create([
            'nama' => 'Peraturan DPRD',
            'kode' => 'PER-DPRD',
            'deskripsi' => 'Peraturan Dewan Perwakilan Rakyat Daerah Kabupaten Bolaang Mongondow Utara',
        ]);

        \App\Models\JenisDokumen::create([
            'nama' => 'Keputusan DPRD',
            'kode' => 'KEP-DPRD',
            'deskripsi' => 'Keputusan Dewan Perwakilan Rakyat Daerah Kabupaten Bolaang Mongondow Utara',
        ]);

        \App\Models\JenisDokumen::create([
            'nama' => 'Keputusan Pimpinan DPRD',
            'kode' => 'KEP-PIM-DPRD',
            'deskripsi' => 'Keputusan Pimpinan Dewan Perwakilan Rakyat Daerah Kabupaten Bolaang Mongondow Utara',
        ]);
    }
}
