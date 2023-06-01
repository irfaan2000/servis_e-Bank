<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jemput extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'id_outlite',
        'kategori_sampah',
        'tanggal',
        'alamat',
        'catatan',
        'lat',
        'lng',
        'status',
    ];
}
