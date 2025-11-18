<?php

namespace App\Http\Controllers;

use App\Models\Favorit;
use App\Models\Produk;
use Illuminate\Http\Request;

class FavoritController extends Controller
{
    /**
     * Display the user's favorite products
     */
    public function index()
    {
        $favorit = Favorit::with('produk')->where('pembeli_id', auth()->id())->paginate(12);
        return view('movr.favorit.index', compact('favorit'));
    }

    /**
     * Toggle favorite status for a product
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
        ]);

        $existingFavorit = Favorit::where('pembeli_id', auth()->id())
            ->where('produk_id', $request->produk_id)
            ->first();

        if ($existingFavorit) {
            $existingFavorit->delete();
            return response()->json(['status' => 'removed', 'message' => 'Produk berhasil dihapus dari favorit']);
        } else {
            Favorit::create([
                'pembeli_id' => auth()->id(),
                'produk_id' => $request->produk_id,
            ]);
            return response()->json(['status' => 'added', 'message' => 'Produk berhasil ditambahkan ke favorit']);
        }
    }
}