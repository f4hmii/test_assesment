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
    public function show($id)
    {
        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);

        // Tampilkan view detail
        return view('movr.produk.show', compact('product'));
    }
}