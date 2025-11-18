<?php

namespace App\Http\Controllers;

use App\Models\Pengguna;
use App\Models\Alamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfilPembeliController extends Controller
{
    /**
     * Display the user's profile
     */
    public function index()
    {
        $user = auth()->user();
        $alamat = Alamat::where('pembeli_id', auth()->id())->get();
        
        return view('movr.profil.index', compact('user', 'alamat'));
    }

    /**
     * Update the user's profile information
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . auth()->id(),
        ]);

        $user = auth()->user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profil.index')->with('status', 'Profil berhasil diperbarui!');
    }

    /**
     * Update the user's password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'Kata sandi saat ini salah!');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('profil.index')->with('status', 'Kata sandi berhasil diperbarui!');
    }

    /**
     * Store a new address
     */
    public function storeAlamat(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kota' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'detail_alamat' => 'required|string',
            'kode_pos' => 'required|string|max:10',
        ]);

        $pembeli_id = auth()->id();

        // If this is set as default, update other addresses to not be default
        if ($request->is_default) {
            Alamat::where('pembeli_id', $pembeli_id)->update(['is_default' => false]);
        } elseif (Alamat::where('pembeli_id', $pembeli_id)->count() === 0) {
            // If this is the first address, make it default
            $request->merge(['is_default' => true]);
        }

        Alamat::create([
            'pembeli_id' => $pembeli_id,
            'label' => $request->label,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'detail_alamat' => $request->detail_alamat,
            'kode_pos' => $request->kode_pos,
            'is_default' => $request->is_default ?? false,
        ]);

        return redirect()->route('profil.index')->with('status', 'Alamat berhasil ditambahkan!');
    }

    /**
     * Update an existing address
     */
    public function updateAlamat(Request $request, $id)
    {
        $alamat = Alamat::where('id', $id)->where('pembeli_id', auth()->id())->firstOrFail();

        $request->validate([
            'label' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'kota' => 'required|string|max:100',
            'kecamatan' => 'required|string|max:100',
            'detail_alamat' => 'required|string',
            'kode_pos' => 'required|string|max:10',
        ]);

        // If this is set as default, update other addresses to not be default
        if ($request->is_default) {
            Alamat::where('pembeli_id', auth()->id())->update(['is_default' => false]);
        }

        $alamat->update([
            'label' => $request->label,
            'provinsi' => $request->provinsi,
            'kota' => $request->kota,
            'kecamatan' => $request->kecamatan,
            'detail_alamat' => $request->detail_alamat,
            'kode_pos' => $request->kode_pos,
            'is_default' => $request->is_default ?? false,
        ]);

        return redirect()->route('profil.index')->with('status', 'Alamat berhasil diperbarui!');
    }

    /**
     * Remove an address
     */
    public function destroyAlamat($id)
    {
        $alamat = Alamat::where('id', $id)->where('pembeli_id', auth()->id())->firstOrFail();
        $alamat->delete();

        return redirect()->route('profil.index')->with('status', 'Alamat berhasil dihapus!');
    }
}