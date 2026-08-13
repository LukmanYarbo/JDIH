<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BeritaHukum extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'gambar',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
