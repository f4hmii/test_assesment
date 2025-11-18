<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Ulasan;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the products
     */
    public function index()
    {
        $produk = Produk::with(['penjual', 'ulasan'])->paginate(12);
        return view('movr.produk.index', compact('produk'));
    }

    /**
     * Display the specified product
     */
    public function show($slug)
    {
        $produk = Produk::where('slug', $slug)->with(['penjual', 'ulasan.pembeli'])->firstOrFail();
        $ulasan = $produk->ulasan()->with('pembeli')->paginate(5);
        
        return view('movr.produk.show', compact('produk', 'ulasan'));
    }
}