<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use LogsActivity;

    protected $fillable = [
        'nama_kantor',
        'nama_singkat_kantor',
        'nama_wilayah',
        'nama_sekretariat',
        'welcome_title',
        'welcome_subtitle',
        'visi',
        'misi',
        'sejarah',
        'struktur_organisasi',
        'logo',
        'banner_header',
        'alamat',
        'telepon',
        'email',
        'dasar_hukum',
        'sk_tim',
        'sop',
        'maklumat_pelayanan',
        'jam_operasional',
        'file_sk_tim',
        'file_sop',
        'video_profil',
        'facebook',
        'instagram',
        'youtube',
        'twitter',
        'whatsapp',
    ];
}
