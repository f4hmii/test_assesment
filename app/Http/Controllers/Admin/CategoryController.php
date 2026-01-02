<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Tampilkan daftar kategori
     */
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('movr.admin.categories.index', compact('categories'));
    }

    /**
     * Tampilkan form untuk membuat kategori baru
     */
    public function create()
    {
        return view('movr.admin.categories.create');
    }

    /**
     * Simpan kategori baru
     */
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

    /**
     * Tampilkan form untuk edit kategori
     */
    public function edit(Category $kategori)
    {
        return view('movr.admin.categories.edit', compact('kategori'));
    }

    /**
     * Update kategori
     */
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

    /**
     * Hapus kategori
     */
    public function destroy(Category $kategori)
    {
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori dihapus!');
    }

    /**
     * Tampilkan detail kategori beserta produk
     */
    public function show(Category $kategori)
    {
        $products = $kategori->products; 
        return view('movr.admin.categories.show', compact('kategori', 'products'));
    }
}