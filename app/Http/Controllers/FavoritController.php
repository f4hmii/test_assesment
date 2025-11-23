<?php

namespace App\Http\Controllers;

use App\Models\Favorit;
use App\Models\Product; // Pastikan pakai Model Product (Baru)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoritController extends Controller
{
    // Menampilkan halaman favorit
    public function index()
    {
        $favorits = Favorit::with('product')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);
        
        return view('movr.favorit.index', compact('favorits'));
    }

    // Toggle Favorit (Tambah/Hapus)
    public function toggle(Request $request)
    {
        // Cek login
        if (!Auth::check()) {
            return response()->json(['status' => 401, 'message' => 'Login required']);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $userId = Auth::id();
        $productId = $request->product_id;

        // Cek apakah produk sudah ada di favorit user ini?
        $existingFavorit = Favorit::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        // Fitur "Check Only" (untuk mengecek status saat halaman dimuat)
        if ($request->input('check_only')) {
            return response()->json(['isFavorited' => (bool)$existingFavorit]);
        }

        if ($existingFavorit) {
            // Jika sudah ada -> HAPUS
            $existingFavorit->delete();
            return response()->json([
                'status' => 'removed',
                'isFavorited' => false
            ]);
        } else {
            // Jika belum ada -> TAMBAH
            Favorit::create([
                'user_id' => $userId,
                'product_id' => $productId,
            ]);
            return response()->json([
                'status' => 'added',
                'isFavorited' => true
            ]);
        }
    }
}