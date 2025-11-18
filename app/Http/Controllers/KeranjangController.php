<?php

namespace App\Http\Controllers;

use App\Models\KeranjangItem;
use App\Models\Produk;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index()
    {
        $keranjangItems = KeranjangItem::with('produk')
            ->where('pembeli_id', auth()->id())
            ->get();
        
        $total = $keranjangItems->sum(function ($item) {
            return $item->jumlah * $item->harga_saat_ini;
        });
        
        return view('movr.keranjang.index', compact('keranjangItems', 'total'));
    }

    /**
     * Add item to cart
     */
    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        
        // Check if product has enough stock
        if ($produk->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        $keranjangItem = KeranjangItem::updateOrCreate(
            [
                'pembeli_id' => auth()->id(),
                'produk_id' => $request->produk_id,
            ],
            [
                'jumlah' => $request->jumlah,
                'harga_saat_ini' => $produk->harga,
            ]
        );

        return redirect()->route('keranjang.index')->with('status', 'Produk berhasil ditambahkan ke keranjang!');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $keranjangItem = KeranjangItem::where('id', $id)
            ->where('pembeli_id', auth()->id())
            ->firstOrFail();
            
        $produk = Produk::findOrFail($keranjangItem->produk_id);
        
        // Check if product has enough stock
        if ($produk->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi!');
        }

        $keranjangItem->update([
            'jumlah' => $request->jumlah,
        ]);

        return redirect()->route('keranjang.index')->with('status', 'Keranjang berhasil diperbarui!');
    }

    /**
     * Remove item from cart
     */
    public function destroy($id)
    {
        $keranjangItem = KeranjangItem::where('id', $id)
            ->where('pembeli_id', auth()->id())
            ->firstOrFail();
        
        $keranjangItem->delete();

        return redirect()->route('keranjang.index')->with('status', 'Produk berhasil dihapus dari keranjang!');
    }
}