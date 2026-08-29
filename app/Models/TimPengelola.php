<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimPengelola extends Model
{
    use HasFactory;

    protected $table = 'tim_pengelolas';

    protected $fillable = [
        'nama',
        'nip',
        'kategori_jabatan',
        'jabatan_tim',
        'jabatan_struktural',
        'divisi',
        'peran_bidang',
        'foto',
        'kontak',
        'tugas',
        'urutan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    public const KATEGORI_JABATAN = [
        'pembina' => 'Pembina',
        'penanggung_jawab' => 'Penanggung Jawab',
        'ketua' => 'Ketua Tim',
        'wakil_ketua' => 'Wakil Ketua Tim',
        'sekretaris' => 'Sekretaris Tim',
        'bidang' => 'Bidang / Divisi Kerja',
    ];

    public const DIVISI_STANDAR = [
        'Bidang Pengumpulan & Pengolahan Dokumen Hukum',
        'Bidang Teknologi Informasi & Jaringan',
        'Bidang Pelayanan Informasi & Publikasi Hukum',
        'Bidang Sosialisasi & Dokumentasi Hukum',
        'Sekretariat & Tata Usaha Tim',
    ];

    public const PERAN_BIDANG_OPTIONS = [
        'Ketua / Koordinator Bidang',
        'Anggota Bidang',
    ];

    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeOrderedHierarchy($query)
    {
        // Custom order: pembina -> penanggung_jawab -> ketua -> wakil_ketua -> sekretaris -> bidang
        return $query->orderByRaw("
            CASE kategori_jabatan
                WHEN 'pembina' THEN 1
                WHEN 'penanggung_jawab' THEN 2
                WHEN 'ketua' THEN 3
                WHEN 'wakil_ketua' THEN 4
                WHEN 'sekretaris' THEN 5
                WHEN 'bidang' THEN 6
                ELSE 7
            END ASC
        ")
        ->orderByRaw("
            CASE peran_bidang
                WHEN 'Ketua / Koordinator Bidang' THEN 1
                WHEN 'Ketua Bidang' THEN 1
                WHEN 'Koordinator Bidang' THEN 1
                ELSE 2
            END ASC
        ")
        ->orderBy('urutan', 'asc')
        ->orderBy('id', 'asc');
    }

    public function getKategoriLabelAttribute()
    {
        return self::KATEGORI_JABATAN[$this->kategori_jabatan] ?? ucfirst(str_replace('_', ' ', $this->kategori_jabatan));
    }
}
