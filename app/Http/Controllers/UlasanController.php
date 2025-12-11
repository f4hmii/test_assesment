<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Produk;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    /**
     * Store a new review for a product
     */
   public function store(Request $request)
{
    // Validasi input
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'komentar' => 'nullable|string',
        'produk_id' => 'required|exists:products,id', // Pastikan validasi ke tabel 'products'
    ]);

    // Cek apakah user sudah pernah review produk ini
    // PERBAIKAN: Gunakan 'product_id' (sesuai kolom DB) bukan 'produk_id'
    $existingReview = Ulasan::where('pembeli_id', auth()->id())
        ->where('product_id', $request->produk_id) 
        ->first();
    
    if ($existingReview) {
        return redirect()->back()->with('error', 'Anda telah memberikan ulasan untuk produk ini sebelumnya.');
    }

    // Simpan Ulasan Baru
    // PERBAIKAN: Gunakan 'product_id'
    Ulasan::create([
        'product_id' => $request->produk_id, // Key DB: product_id, Value dari Form: produk_id
        'pembeli_id' => auth()->id(),
        'rating' => $request->rating,
        'komentar' => $request->komentar,
    ]);

    return redirect()->back()->with('success', 'Terima kasih atas ulasan Anda!');
}
}