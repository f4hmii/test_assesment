<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'price', 
        'description', 
        'image', 
        'stock',       // Pastikan ada stok sesuai screenshot
        'category_id'  // Wajib ada
    ];

    // Relasi: Satu Produk milik satu Kategori
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}