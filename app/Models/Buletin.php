<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buletin extends Model
{
    protected $fillable = [
        'edisi',
        'tahun',
        'judul',
        'cover_image',
        'file_pdf',
        'deskripsi',
        'downloads',
    ];
}
