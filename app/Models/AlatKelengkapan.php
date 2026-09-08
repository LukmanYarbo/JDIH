<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AlatKelengkapan extends Model
{
    use LogsActivity;

    public const TIPE_LABELS = [
        'pimpinan' => 'Pimpinan DPRD',
        'komisi' => 'Komisi',
        'banggar' => 'Badan Anggaran (BANGGAR)',
        'banmus' => 'Badan Musyawarah (BANMUS)',
        'bapemperda' => 'Badan Pembuat Peraturan Daerah (BAPEMPERDA)',
        'bk' => 'Badan Kehormatan (BK)',
    ];

    public const TIPE_ICONS = [
        'pimpinan' => 'bi-person-badge',
        'komisi' => 'bi-diagram-3',
        'banggar' => 'bi-cash-stack',
        'banmus' => 'bi-people',
        'bapemperda' => 'bi-journal-bookmark-fill',
        'bk' => 'bi-shield-check',
    ];

    protected $fillable = [
        'nama',
        'tipe',
        'keterangan',
        'no_urut',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function keanggotaans(): HasMany
    {
        return $this->hasMany(KeanggotaanAlatKelengkapan::class)->ordered();
    }

    public function labelTipe(): string
    {
        return self::TIPE_LABELS[$this->tipe] ?? ucfirst($this->tipe);
    }

    public function iconTipe(): string
    {
        return self::TIPE_ICONS[$this->tipe] ?? 'bi-collection';
    }

    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByRaw("FIELD(tipe, 'pimpinan', 'komisi', 'banggar', 'banmus', 'bapemperda', 'bk')")
            ->orderBy('no_urut')
            ->orderBy('nama');
    }
}
