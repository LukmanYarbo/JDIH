<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use LogsActivity;

    protected $fillable = [
        'judul',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'deskripsi',
        'pelaksana',
        'mitra_kerja',
        'status',
        'is_active_ticker',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'waktu_selesai' => 'datetime',
        'is_active_ticker' => 'boolean',
    ];
}
