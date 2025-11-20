<?php

namespace App\Http\Controllers;

use App\Models\Favorit;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FavoritController extends Controller
{
    /**
     * Display the user's favorite products
     */
    public function index()
    {
        $favorit = Favorit::with('produk')
            ->where('pembeli_id', auth()->id())
            ->paginate(12);
        
        return view('movr.favorit.index', compact('favorit'));
    }

    /**
     * Toggle favorite status for a product
     * - Jika produk sudah favorite, hapus dari favorite
     * - Jika produk belum favorite, tambahkan ke favorite
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
        ]);

        $produk = Produk::findOrFail($request->produk_id);

        // Jika ada parameter check_only, hanya check status
        if ($request->input('check_only')) {
            $isFavorited = Favorit::where('pembeli_id', auth()->id())
                ->where('produk_id', $request->produk_id)
                ->exists();

            return response()->json([
                'isFavorited' => $isFavorited
            ]);
        }

        $existingFavorit = Favorit::where('pembeli_id', auth()->id())
            ->where('produk_id', $request->produk_id)
            ->first();

        if ($existingFavorit) {
            // Jika sudah favorite, hapus
            $existingFavorit->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Produk berhasil dihapus dari favorit',
                'isFavorited' => false
            ]);
        } else {
            // Jika belum favorite, tambahkan
            Favorit::create([
                'pembeli_id' => auth()->id(),
                'produk_id' => $request->produk_id,
            ]);
            return response()->json([
                'status' => 'added',
                'message' => 'Produk berhasil ditambahkan ke favorit',
                'isFavorited' => true
            ]);
        }
    }

}