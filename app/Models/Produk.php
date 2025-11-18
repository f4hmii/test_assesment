<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'penjual_id',
        'nama_produk',
        'slug',
        'deskripsi',
        'harga',
        'stok',
        'gambar',
        'kategori',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];

    /**
     * Get the seller (penjual) that owns this product
     */
    public function penjual()
    {
        return $this->belongsTo(Pengguna::class, 'penjual_id');
    }

    /**
     * Get all keranjang items for this product
     */
    public function keranjangItems()
    {
        return $this->hasMany(KeranjangItem::class, 'produk_id');
    }

    /**
     * Get all ulasan (reviews) for this product
     */
    public function ulasan()
    {
        return $this->hasMany(Ulasan::class, 'produk_id');
    }

    /**
     * Get all favorit records for this product
     */
    public function favorit()
    {
        return $this->hasMany(Favorit::class, 'produk_id');
    }
}