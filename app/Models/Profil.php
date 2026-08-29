<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    protected $fillable = [
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
