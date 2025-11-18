<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Alamat extends Model
{
    use HasFactory;

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

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the customer (pembeli) that owns this address
     */
    public function pembeli()
    {
        return $this->belongsTo(Pengguna::class, 'pembeli_id');
    }
}