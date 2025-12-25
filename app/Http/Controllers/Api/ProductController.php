<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category; // <--- WAJIB: Jangan lupa import ini!
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // 1. Ambil Semua Produk (Search & Filter)
    public function index(Request $request)
    {
        $query = Product::query();

        // Fitur Search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Fitur Filter by Category ID (Query Param)
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Load relasi 'category' agar nama kategori muncul di Flutter
        $products = $query->with(['category'])->latest()->get();

        return response()->json([
            'message' => 'List produk berhasil diambil',
            'data' => $products
        ]);
    }

    // 2. Ambil Daftar Kategori (INI YANG ANDA BUTUHKAN UNTUK FLUTTER)
    public function categories()
    {
        // Kita ambil semua kategori
        $categories = Category::all();

        return response()->json([
            'message' => 'List kategori berhasil diambil',
            'data' => $categories
        ]);
    }

    // 3. Ambil Produk Berdasarkan Kategori (Spesifik)
    public function getByCategory($id)
    {
        $products = Product::where('category_id', $id)
            ->with(['category'])
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Produk berdasarkan kategori berhasil diambil',
            'data' => $products
        ]);
    }
}