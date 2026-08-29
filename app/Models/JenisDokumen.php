<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisDokumen extends Model
{
    protected $fillable = [
        'tipe_dokumen',
        'nama',
        'kode',
        'deskripsi',
        'urutan',
        'icon',
    ];

    public function dokumenHukums()
    {
        return $this->hasMany(DokumenHukum::class);
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
