<?php

namespace App\Http\Controllers;

use App\Models\Produk;

class HalamanUtamaController extends Controller
{
    /**
     * Display the homepage with featured products
     */
    public function index()
    {
        $produk = Produk::with('penjual')->latest()->take(8)->get();
        return view('movr.home', compact('produk'));
    }
}