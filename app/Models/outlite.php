<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class outlite extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'nama_outlite',
        'alamat',
        'no_hp',
        'status',
        'lng',
        'lat',
    ];
}
