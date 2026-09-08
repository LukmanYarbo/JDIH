<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class BeritaHukum extends Model
{
    use LogsActivity;

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
