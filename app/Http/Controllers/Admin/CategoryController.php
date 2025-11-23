<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // 1. Menampilkan Daftar Kategori
    public function index()
    {
        $categories = Category::withCount('products')->get(); // Mengambil jumlah produk juga
        return view('movr.admin.categories.index', compact('categories'));
    }

    // 2. Form Tambah Kategori
    public function create()
    {
        return view('movr.admin.categories.create');
    }

    // 3. Simpan Kategori Baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dibuat!');
    }

    // 4. Form Edit Kategori
    public function edit(Category $kategori)
    {
        return view('movr.admin.categories.edit', compact('kategori'));
    }

    // 5. Update Kategori
    public function update(Request $request, Category $kategori)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $kategori->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    // 6. Hapus Kategori
    public function destroy(Category $kategori)
    {
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori dihapus!');
    }

    // 7. LIHAT DETAIL (Fitur yang Anda minta: Lihat produk dalam kategori)
    public function show(Category $kategori)
    {
        // Ambil produk yang ada di kategori ini
        $products = $kategori->products; 
        return view('movr.admin.categories.show', compact('kategori', 'products'));
    }
}