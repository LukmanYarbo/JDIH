<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IkmVote extends Model
{
    protected $fillable = [
        'jawaban',
        'ip_address',
        'user_agent',
    ];
}
