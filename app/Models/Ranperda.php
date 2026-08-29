<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ranperda extends Model
{
    protected $fillable = [
        'tahun',
        'nomor_propemperda',
        'judul',
        'pemrakarsa',
        'tahap_terakhir',
        'tanggal_mulai_pembahasan',
        'tanggal_akhir_pembahasan',
        'tanggal_penetapan',
        'status',
        'keterangan',
        'file_naskah_akademik',
        'file_rancangan',
        'file_evaluasi',
        'hits',
    ];

    protected $casts = [
        'tanggal_mulai_pembahasan' => 'date',
        'tanggal_akhir_pembahasan' => 'date',
        'tanggal_penetapan' => 'date',
    ];

    public static function getTahapanLabels(): array
    {
        return [
            1 => 'Usulan & Pengajuan',
            2 => 'Naskah Akademik',
            3 => 'Harmonisasi & Sinkronisasi',
            4 => 'Pembahasan Pansus / Komisi',
            5 => 'Rapat Paripurna / Persetujuan',
            6 => 'Fasilitasi & Evaluasi Gubernur/Kemendagri',
            7 => 'Penetapan & Pengundangan',
        ];
    }

    public function getTahapanNameAttribute(): string
    {
        return self::getTahapanLabels()[$this->tahap_terakhir] ?? 'Tahap ' . $this->tahap_terakhir;
    }
}
