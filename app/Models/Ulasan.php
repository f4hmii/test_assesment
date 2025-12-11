<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// Pastikan meng-import Model yang benar
use App\Models\Product; 
use App\Models\User;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasan';

    protected $fillable = [
        'product_id', // <--- PENTING: Sesuai nama kolom di database (Bahasa Inggris)
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
    public function product() // Saya ganti jadi product() agar konsisten
    {
        // Relasi ke Model Product, menggunakan kolom 'product_id'
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the customer (pembeli) who wrote this review
     */
    public function pembeli()
    {
        // Relasi ke Model User (Bawaan Laravel biasanya User, bukan Pengguna)
        return $this->belongsTo(User::class, 'pembeli_id');
    }
}