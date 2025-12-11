<?php

namespace App\Http\Controllers;

use App\Models\Product; // Gunakan Model Product (Baru)
use App\Models\Category;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Menampilkan daftar semua produk
     */
    public function index(Request $request)
    {
        // Mulai Query dari tabel products
        $query = Product::with('category');

        // Logika Filter Kategori (Jika ada request kategori)
        if ($request->has('kategori') && $request->kategori != '') {
            $slug = $request->kategori;
            $query->whereHas('category', function($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        // Ambil data dengan pagination (9 produk per halaman)
        // Kita namakan variabelnya '$products' (Inggris)
        $products = $query->latest()->paginate(9);

        // Ambil semua kategori untuk sidebar filter
        $categories = Category::all();

        return view('movr.produk.index', compact('products', 'categories'));
    }

    /**
     * Menampilkan detail 1 produk
     */
    /**
     * Menampilkan detail 1 produk
     */
    public function show($id)
    {
        // 1. Cari produk utama (Eager load category & penjual agar hemat query)
        $product = Product::with(['category', 'penjual'])->findOrFail($id);

        // 2. Ambil Ulasan (Pagination 5 per halaman)
        $ulasan = $product->ulasan()->with('pembeli')->latest()->paginate(5);

        // 3. TAMBAHKAN INI: Logika Produk Serupa
        // Syarat: Kategori sama, TAPI bukan produk yang sedang dibuka
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $id) // Exclude produk ini sendiri
            ->inRandomOrder()        // Acak urutannya
            ->limit(3)               // Ambil 3 saja (sesuai layout grid)
            ->get();

        // 4. Kirim 'product', 'ulasan', DAN 'relatedProducts' ke view
        return view('movr.produk.show', compact('product', 'ulasan', 'relatedProducts'));
    }
}