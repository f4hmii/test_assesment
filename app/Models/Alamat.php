<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    protected $table = 'alamat'; 

    protected $fillable = [
        'pembeli_id',
        'label',
        'provinsi',
        'kota',
        'kecamatan',
        'detail_alamat',
        'kode_pos',
        'is_default',
    ];
}
