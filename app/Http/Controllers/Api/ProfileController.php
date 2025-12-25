<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Alamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    // Mengambil data profil dan alamat
    public function index()
    {
        $user = auth()->user();
        $alamat = Alamat::where('pembeli_id', $user->id)->get();

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'alamat' => $alamat
        ]);
    }

    // Update Profil (Nama & Email)
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));

        return response()->json([
            'status' => 'success',
            'message' => 'Profil berhasil diperbarui',
            'user' => $user
        ]);
    }

    // Tambah Alamat Baru via API
    public function storeAlamat(Request $request)
    {
        $request->validate([
            'label' => 'required|string',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'detail_alamat' => 'required|string',
            'kode_pos' => 'required|string',
        ]);

        $is_default = $request->boolean('is_default');
        
        // Jika alamat pertama atau is_default true, reset yang lain
        if ($is_default || Alamat::where('pembeli_id', auth()->id())->count() === 0) {
            Alamat::where('pembeli_id', auth()->id())->update(['is_default' => 0]);
            $is_default = 1;
        }

        $alamat = Alamat::create([
            'pembeli_id' => auth()->id(),
            'label' => $request->label,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'detail_alamat' => $request->detail_alamat,
            'kode_pos' => $request->kode_pos,
            'is_default' => $is_default,
        ]);

        return response()->json(['status' => 'success', 'data' => $alamat]);
    }
    
    public function destroyAlamat($id)
    {
        $alamat = Alamat::where('id', $id)->where('pembeli_id', auth()->id())->firstOrFail();
        $alamat->delete();
        return response()->json(['status' => 'success', 'message' => 'Alamat dihapus']);
    }
}