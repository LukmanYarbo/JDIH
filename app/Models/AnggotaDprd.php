<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaDprd extends Model
{
    protected $fillable = [
        'nama',
        'jabatan',
        'fraksi',
        'dapil',
        'foto',
        'no_urut',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public const JABATAN_LABELS = [
        'ketua' => 'Ketua DPRD',
        'wakil_ketua' => 'Wakil Ketua DPRD',
        'anggota' => 'Anggota DPRD',
    ];

    public function getLabelJabatanAttribute(): string
    {
        return self::JABATAN_LABELS[$this->jabatan] ?? ucfirst($this->jabatan);
    }

    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByRaw("FIELD(jabatan, 'ketua', 'wakil_ketua', 'anggota')")
            ->orderBy('no_urut')
            ->orderBy('nama');
    }
}
