<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favorit extends Model
{
    use HasFactory;

    protected $table = 'favorit';

    protected $fillable = [
        'pembeli_id',
        'produk_id',
    ];

    /**
     * Get the customer (pembeli) who favorited this product
     */
    public function pembeli()
    {
        return $this->belongsTo(Pengguna::class, 'pembeli_id');
    }

    /**
     * Get the product that was favorited
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}