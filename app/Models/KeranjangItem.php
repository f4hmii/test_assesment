<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KeranjangItem extends Model
{
    use HasFactory;

    protected $table = 'keranjang_items';

    protected $fillable = [
        'pembeli_id',
        'produk_id',
        'jumlah',
        'harga_saat_ini',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga_saat_ini' => 'decimal:2',
    ];

    /**
     * Get the customer (pembeli) that owns this cart item
     */
    public function pembeli()
    {
        return $this->belongsTo(Pengguna::class, 'pembeli_id');
    }

    /**
     * Get the product for this cart item
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}