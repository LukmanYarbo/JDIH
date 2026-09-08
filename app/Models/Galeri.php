<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    use LogsActivity;

    protected $fillable = [
        'judul',
        'tipe',
        'file_path',
        'video_url',
        'keterangan',
    ];
}
