<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HalamanUtamaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfilPembeliController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\FavoritController;
use App\Http\Controllers\AdminProdukController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Guest routes
Route::get('/', [HalamanUtamaController::class, 'index'])->name('home');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{slug}', [ProdukController::class, 'show'])->name('produk.show');

// Authentication routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Keranjang routes
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::put('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');

    // Checkout routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/{id}', [CheckoutController::class, 'show'])->name('pembayaran.show');

    // Profil routes
    Route::get('/profil', [ProfilPembeliController::class, 'index'])->name('profil.index');
    Route::put('/profil', [ProfilPembeliController::class, 'update'])->name('profil.update');
    Route::post('/profil/password', [ProfilPembeliController::class, 'updatePassword'])->name('profil.password.update');

    // Alamat routes
    Route::post('/profil/alamat', [ProfilPembeliController::class, 'storeAlamat'])->name('profil.alamat.store');
    Route::put('/profil/alamat/{id}', [ProfilPembeliController::class, 'updateAlamat'])->name('profil.alamat.update');
    Route::delete('/profil/alamat/{id}', [ProfilPembeliController::class, 'destroyAlamat'])->name('profil.alamat.destroy');

    // Ulasan routes
    Route::post('/ulasan', [UlasanController::class, 'store'])->name('ulasan.store');

    // Favorit routes
    Route::get('/favorit', [FavoritController::class, 'index'])->name('favorit.index');
    Route::post('/favorit/toggle', [FavoritController::class, 'toggle'])->name('favorit.toggle');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('movr.admin.dashboard');
    })->name('admin.dashboard');

    // Admin Produk routes
    Route::get('/produk', [AdminProdukController::class, 'index'])->name('admin.produk.index');
    Route::get('/produk/create', [AdminProdukController::class, 'create'])->name('admin.produk.create');
    Route::post('/produk', [AdminProdukController::class, 'store'])->name('admin.produk.store');
    Route::get('/produk/{id}/edit', [AdminProdukController::class, 'edit'])->name('admin.produk.edit');
    Route::put('/produk/{id}', [AdminProdukController::class, 'update'])->name('admin.produk.update');
    Route::delete('/produk/{id}', [AdminProdukController::class, 'destroy'])->name('admin.produk.destroy');
});
