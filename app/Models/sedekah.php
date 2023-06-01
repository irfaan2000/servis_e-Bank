<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sedekah extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_user',
        'id_outlite',
        'nama_sampah',
        'foto',
        'opsi',
        'lat',
        'lng',
        'status',
    ];
}
