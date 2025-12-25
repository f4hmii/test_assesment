<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController; 
use App\Http\Controllers\Api\KeranjangController; 
use App\Http\Controllers\Api\ProfileController; // <--- PERBAIKAN: Baris ini WAJIB ada

// SEMUA ROUTE KITA MASUKKAN KE DALAM 'v1'
Route::prefix('v1')->group(function () {

    // --- PUBLIC ROUTES (Bisa diakses tanpa login) ---
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/categories', [ProductController::class, 'categories']);
    Route::get('/products/category/{id}', [ProductController::class, 'getByCategory']);

    // --- AUTH ROUTES ---
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    // --- PROTECTED ROUTES (Harus Login / Pakai Token) ---
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/user', function (Request $request) {
            return $request->user();
        });

        // Keranjang
        Route::get('/cart', [KeranjangController::class, 'index']);      
        Route::post('/cart', [KeranjangController::class, 'store']);     
        Route::put('/cart/{id}', [KeranjangController::class, 'update']); 
        Route::delete('/cart/{id}', [KeranjangController::class, 'destroy']); 

        // Profil & Alamat
        Route::get('/profile', [ProfileController::class, 'index']);
        Route::put('/profile/update', [ProfileController::class, 'update']);
        Route::post('/profile/alamat', [ProfileController::class, 'storeAlamat']);
        Route::delete('/profile/alamat/{id}', [ProfileController::class, 'destroyAlamat']);
    });
});