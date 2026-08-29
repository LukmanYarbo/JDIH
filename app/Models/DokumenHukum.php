<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenHukum extends Model
{
    protected $fillable = [
        'jenis_dokumen_id',
        'tipe_dokumen',
        'judul',
        'nomor',
        'tahun',
        'tanggal_ditetapkan',
        'tanggal_pengundangan',
        'penandatangan',
        'pemrakarsa',
        'tempat_terbit',
        'sumber',
        'subjek',
        'bidang_hukum',
        'bahasa',
        'lokasi_arsip',
        'file_pdf',
        'abstrak',
        'file_abstrak',
        'file_lampiran',
        'file_size',
        'status',
        'keterangan_status',
        'hits',
        'downloads',
    ];

    protected $casts = [
        'tanggal_ditetapkan' => 'date',
        'tanggal_pengundangan' => 'date',
        'tahun' => 'integer',
        'hits' => 'integer',
        'downloads' => 'integer',
    ];

    public function jenisDokumen()
    {
        return $this->belongsTo(JenisDokumen::class);
    }

    public function scopeProdukHukum($query)
    {
        return $query->where('tipe_dokumen', 'Produk Hukum');
    }

    public function scopeMonografiHukum($query)
    {
        return $query->where('tipe_dokumen', 'Monografi Hukum');
    }

    public function scopeArtikelHukum($query)
    {
        return $query->where('tipe_dokumen', 'Artikel Hukum');
    }

    public function scopePutusanPengadilan($query)
    {
        return $query->where('tipe_dokumen', 'Putusan Pengadilan');
    }
}
