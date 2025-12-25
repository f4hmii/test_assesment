<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response; // <--- PENTING: Untuk bikin respon gambar
use Illuminate\Support\Facades\File;     // <--- PENTING: Untuk baca file dari folder

use App\Http\Controllers\HalamanUtamaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfilPembeliController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\FavoritController;
use App\Http\Controllers\AdminProdukController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\AdminOrderController; 

/*
|--------------------------------------------------------------------------
| SOLUSI GAMBAR FLUTTER (ULTIMATE FIX)
|--------------------------------------------------------------------------
*/
Route::get('/image-proxy/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);

    if (!File::exists($filePath)) {
        $altPath = storage_path('app/public/products/' . $path);
        if (File::exists($altPath)) {
            $filePath = $altPath;
        } else {
            return Response::json(['message' => 'Image not found'], 404)
                ->header("Access-Control-Allow-Origin", "*");
        }
    }

    $file = File::get($filePath);
    $type = File::mimeType($filePath);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    $response->header("Access-Control-Allow-Origin", "*"); 
    $response->header("Access-Control-Allow-Methods", "GET, OPTIONS");

    return $response;
})->where('path', '.*');

/*
|--------------------------------------------------------------------------
| Public / Guest Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HalamanUtamaController::class, 'index'])->name('home');
Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
Route::get('/produk/{id}', [ProdukController::class, 'show'])->name('produk.show');

// Authentication Route
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| MIDTRANS WEBHOOK
|--------------------------------------------------------------------------
*/
Route::post('/midtrans/webhook', [MidtransController::class, 'handleNotification'])->name('midtrans.webhook');

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    
    // Keranjang routes
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::put('/keranjang/{id}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');

    // Checkout Routes
    Route::post('/checkout/buy-now', [CheckoutController::class, 'buyNow'])->name('checkout.buyNow');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');

    // Payment status
    Route::get('/payment/status/{orderId}', [MidtransController::class, 'paymentStatus'])->name('payment.status');

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

    // Customer Dashboard routes
    Route::get('/dashboard/pelanggan', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
    Route::get('/dashboard/pelanggan/order/{id}', [CustomerDashboardController::class, 'show'])->name('customer.order.show');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Role: Admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // Route Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Route Laporan Pendapatan (TAMBAHAN DISINI)
    Route::get('/laporan', [AdminDashboardController::class, 'report'])->name('report');

    // Route Orders
    Route::resource('orders', AdminOrderController::class)->except(['create', 'store']);

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