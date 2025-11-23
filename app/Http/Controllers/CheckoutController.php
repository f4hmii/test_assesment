<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Menangani tombol "Beli" (Direct Buy) dari Halaman Utama
     */
    public function buyNow(Request $request)
    {
        // Validasi
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        // Ambil data produk dari database
        $product = Product::findOrFail($request->product_id);

        // Siapkan data untuk halaman checkout
        $checkoutItem = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'image' => $product->image,
            'qty' => 1, // Default beli 1 dulu
            'total' => $product->price
        ];

        // Simpan data ke SESSION sementara
        session(['checkout_type' => 'direct']);
        session(['checkout_items' => [$checkoutItem]]);
        
        // Arahkan user ke halaman checkout
        return redirect()->route('checkout.index');
    }

    /**
     * Menampilkan Halaman Checkout dengan Perhitungan Total
     */
    public function index()
    {
        // Ambil item dari session
        $items = session('checkout_items');

        // Jika tidak ada item, kembali ke home
        if (!$items) {
            return redirect()->route('home')->with('error', 'Tidak ada item untuk di-checkout');
        }

        // 1. Hitung Subtotal (Harga Barang)
        $subtotal = collect($items)->sum('total');

        // 2. Tentukan Biaya Tambahan (Bisa diubah sesuai kebutuhan)
        $shippingCost = 15000; // Ongkos Kirim
        $serviceFee = 1000;    // Biaya Layanan

        // 3. Hitung Grand Total (Total Bayar)
        $grandTotal = $subtotal + $shippingCost + $serviceFee;
        
        // Kirim semua variabel perhitungan ke View
        return view('movr.checkout.index', compact('items', 'subtotal', 'shippingCost', 'serviceFee', 'grandTotal'));
    }
}