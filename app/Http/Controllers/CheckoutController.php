<?php

namespace App\Http\Controllers;

use App\Models\KeranjangItem;
use App\Models\Pembayaran;
use App\Models\Alamat;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page
     */
    public function index()
    {
        $keranjangItems = KeranjangItem::with('produk')
            ->where('pembeli_id', auth()->id())
            ->get();
        
        $total = $keranjangItems->sum(function ($item) {
            return $item->jumlah * $item->harga_saat_ini;
        });
        
        $alamat = Alamat::where('pembeli_id', auth()->id())->get();
        
        return view('movr.checkout.index', compact('keranjangItems', 'total', 'alamat'));
    }

    /**
     * Process the checkout and create payment record
     */
    public function store(Request $request)
    {
        $request->validate([
            'alamat_id' => 'required|exists:alamat,id',
            'metode' => 'required|in:cod,transfer,kartu_kredit',
        ]);

        $keranjangItems = KeranjangItem::with('produk')
            ->where('pembeli_id', auth()->id())
            ->get();

        if ($keranjangItems->isEmpty()) {
            return redirect()->route('checkout.index')->with('error', 'Keranjang kosong!');
        }

        // Calculate total
        $total = $keranjangItems->sum(function ($item) {
            return $item->jumlah * $item->harga_saat_ini;
        });

        // Create payment record
        $pembayaran = Pembayaran::create([
            'pembeli_id' => auth()->id(),
            'total' => $total,
            'status' => 'pending',
            'metode' => $request->metode,
            'detail_json' => [
                'alamat_id' => $request->alamat_id,
                'items' => $keranjangItems->map(function ($item) {
                    return [
                        'produk_id' => $item->produk_id,
                        'nama_produk' => $item->produk->nama_produk,
                        'jumlah' => $item->jumlah,
                        'harga' => $item->harga_saat_ini,
                    ];
                })->toArray(),
            ],
        ]);

        // Clear cart
        $keranjangItems->each->delete();

        return redirect()->route('pembayaran.show', $pembayaran->id)->with('status', 'Pesanan berhasil dibuat!');
    }

    /**
     * Show payment details
     */
    public function show($id)
    {
        $pembayaran = Pembayaran::with('pembeli')->findOrFail($id);
        
        // Decode the detail_json to extract items and address
        $alamat = null;
        if (isset($pembayaran->detail_json['alamat_id'])) {
            $alamat = Alamat::find($pembayaran->detail_json['alamat_id']);
        }
        
        return view('movr.checkout.show', compact('pembayaran', 'alamat'));
    }
}