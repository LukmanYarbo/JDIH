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
        'alamat',
        'telepon',
        'email',
    ];
}
