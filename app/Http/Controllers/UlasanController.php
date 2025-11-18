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
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'rating' => 'required|integer|between:1,5',
            'komentar' => 'nullable|string|max:1000',
        ]);

        // Check if user has already reviewed this product
        $existingReview = Ulasan::where('pembeli_id', auth()->id())
            ->where('produk_id', $request->produk_id)
            ->first();
        
        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda telah memberikan ulasan untuk produk ini sebelumnya.');
        }

        Ulasan::create([
            'produk_id' => $request->produk_id,
            'pembeli_id' => auth()->id(),
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->back()->with('status', 'Ulasan berhasil ditambahkan!');
    }
}