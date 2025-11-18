<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasan';

    protected $fillable = [
        'produk_id',
        'pembeli_id',
        'rating',
        'komentar',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    /**
     * Get the product that this review belongs to
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    /**
     * Get the customer (pembeli) who wrote this review
     */
    public function pembeli()
    {
        return $this->belongsTo(Pengguna::class, 'pembeli_id');
    }
}