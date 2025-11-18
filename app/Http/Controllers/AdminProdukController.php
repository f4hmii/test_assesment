<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminProdukController extends Controller
{
    /**
     * Display a listing of the products
     */
    public function index()
    {
        $produk = Produk::with('penjual')->paginate(10);
        return view('movr.admin.produk.index', compact('produk'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        return view('movr.admin.produk.create');
    }

    /**
     * Store a newly created product in storage
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('produk', 'public');
        }

        Produk::create([
            'penjual_id' => auth()->id(),
            'nama_produk' => $request->nama_produk,
            'slug' => Str::slug($request->nama_produk) . '-' . time(),
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'kategori' => $request->kategori,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('admin.produk.index')->with('status', 'Produk berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('movr.admin.produk.edit', compact('produk'));
    }

    /**
     * Update the specified product in storage
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $gambarPath = $produk->gambar;
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($gambarPath) {
                \Storage::disk('public')->delete($gambarPath);
            }
            $gambarPath = $request->file('gambar')->store('produk', 'public');
        }

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'kategori' => $request->kategori,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('admin.produk.index')->with('status', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified product from storage
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        
        // Delete image if exists
        if ($produk->gambar) {
            \Storage::disk('public')->delete($produk->gambar);
        }
        
        $produk->delete();

        return redirect()->route('admin.produk.index')->with('status', 'Produk berhasil dihapus!');
    }
}