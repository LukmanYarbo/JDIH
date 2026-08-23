<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KeanggotaanAlatKelengkapan extends Model
{
    public const JABATAN_LABELS = [
        'ketua' => 'Ketua',
        'wakil' => 'Wakil',
        'sekretaris' => 'Sekretaris',
        'anggota' => 'Anggota',
    ];

    protected $table = 'keanggotaan_alat_kelengkapans';

    protected $fillable = [
        'alat_kelengkapan_id',
        'anggota_dprd_id',
        'jabatan',
        'no_urut',
    ];

    public function alatKelengkapan(): BelongsTo
    {
        return $this->belongsTo(AlatKelengkapan::class);
    }

    public function anggotaDprd(): BelongsTo
    {
        return $this->belongsTo(AnggotaDprd::class);
    }

    public function labelJabatan(): string
    {
        return self::JABATAN_LABELS[$this->jabatan] ?? ucfirst($this->jabatan);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByRaw("FIELD(jabatan, 'ketua', 'wakil', 'sekretaris', 'anggota')")
            ->orderBy('no_urut')
            ->orderBy('id');
    }
}
