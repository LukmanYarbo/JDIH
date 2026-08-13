<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenHukum extends Model
{
    protected $fillable = [
        'jenis_dokumen_id',
        'judul',
        'nomor',
        'tahun',
        'tanggal_ditetapkan',
        'file_pdf',
        'abstrak',
        'status',
        'hits',
    ];

    public function jenisDokumen()
    {
        return $this->belongsTo(JenisDokumen::class);
    }
}
