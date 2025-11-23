<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HalamanUtamaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\CheckoutController; // Pastikan ini ada
use App\Http\Controllers\ProfilPembeliController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\FavoritController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\Admin\CategoryController;

// Guest Routes (Bisa diakses siapa saja
Route::get('/', [HalamanUtamaController::class, 'index'])->name('home');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
// Note: Pastikan di database & controller pakai ID jika belum setup slug, 
// tapi jika controller pakai slug, biarkan {slug}. 
// Sesuai perbaikan home.blade.php terakhir kita pakai ID di linknya, jadi sebaiknya:
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show'); 
// Authentication Route
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// Authenticated Routes (Harus Login
Route::middleware('auth')->group(function () {
    
    // Keranjang routes
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::put('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');

    // --- CHECKOUT ROUTES (BARU DITAMBAHKAN) ---
    // Route untuk tombol "Beli" (Direct Checkout)
    Route::post('/checkout/buy-now', [CheckoutController::class, 'buyNow'])->name('checkout.buyNow');
    // Route untuk menampilkan halaman Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');

    // Profil routes
    Route::get('/profil', [ProfilPembeliController::class, 'index'])->name('profil.index');
    Route::put('/profil', [ProfilPembeliController::class, 'update'])->name('profil.update');
    Route::post('/profil/password', [ProfilPembeliController::class, 'updatePassword'])->name('profil.password.update');

    // Alamat routes
    Route::post('/profil/alamat', [ProfilPembeliController::class, 'storeAlamat'])->name('profil.alamat.store');
    Route::put('/profil/alamat/{id}', [ProfilPembeliController::class, 'updateAlamat'])->name('profil.alamat.update');
    Route::delete('/profil/alamat/{id}', [ProfilPembeliController::class, 'destroyAlamat'])->name('profil.alamat.destroy');
    Route::get('/profil/alamat/{id}', [ProfilPembeliController::class, 'edit'])->name('profil.alamat.edit');

    // Ulasan routes
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');
    
    // Favorit routes
    Route::get('/favorit', [FavoritController::class, 'index'])->name('favorit.index');
    Route::post('/favorit/toggle', [FavoritController::class, 'toggle'])->name('favorit.toggle');
    
});
// Admin Routes (Hanya untuk Role Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    
    // Route Dashboard
    Route::get('/dashboard', function () {
        return view('movr.admin.dashboard');
    })->name('dashboard');

    // Route Kategori (Resource)
    Route::resource('kategori', CategoryController::class);

    // Route Admin Produk
    Route::get('/produk', [AdminProdukController::class, 'index'])->name('produk.index');
    Route::get('/produk/create', [AdminProdukController::class, 'create'])->name('produk.create');
    Route::post('/produk', [AdminProdukController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [AdminProdukController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [AdminProdukController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [AdminProdukController::class, 'destroy'])->name('produk.destroy');
});