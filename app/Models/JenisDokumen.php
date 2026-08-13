<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisDokumen extends Model
{
    protected $fillable = ['nama', 'kode', 'deskripsi'];

    public function dokumenHukums()
    {
        return $this->hasMany(DokumenHukum::class);
    }
}
