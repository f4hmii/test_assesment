<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Product; // Import Model Product (Baru)
use App\Models\User;    // Import Model User

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
        'harga_saat_ini' => 'decimal:0',
    ];

    public function pembeli()
    {
        return $this->belongsTo(User::class, 'pembeli_id');
    }

    // Relasi ke Model Product (Bahasa Inggris)
    public function produk()
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }
    public function product()
    {
        // Kita menggunakan belongsTo ke model Product.
        // Parameter kedua 'produk_id' WAJIB ditulis karena di migrasi Anda nama kolomnya 'produk_id', bukan 'product_id'.
        return $this->belongsTo(Product::class, 'produk_id');
    }
}