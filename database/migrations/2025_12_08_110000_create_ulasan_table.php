<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ulasan', function (Blueprint $table) {
            $table->id();
            
            // PERBAIKAN 1 & 2: 
            // Ubah 'produk_id' jadi 'product_id'
            // Ubah constrained('produk') jadi constrained('products')
            $table->foreignId('product_id')
                  ->constrained('products') 
                  ->onDelete('cascade');

            // Pastikan tabel 'users' sudah ada sebelum migrasi ini jalan
            $table->foreignId('pembeli_id')
                  ->constrained('users')
                  ->onDelete('cascade');

            // PERBAIKAN 3:
            // Hapus ->between(), ganti jadi tinyInteger agar hemat memori
            $table->tinyInteger('rating')->unsigned()->default(5); 
            
            $table->text('komentar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};