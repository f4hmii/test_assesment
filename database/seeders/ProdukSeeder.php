<?php

namespace Database\Seeders;

use App\Models\Produk;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the admin user to be the seller for sample products
        $admin = Pengguna::where('role', 'admin')->first();
        
        if (!$admin) {
            // If no admin exists, create one
            $admin = Pengguna::create([
                'name' => 'Admin MOVR',
                'email' => 'admin@movr.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'admin',
            ]);
        }

        // Create sample products
        $products = [
            [
                'nama_produk' => 'Sepatu Lari Premium',
                'deskripsi' => 'Sepatu lari dengan teknologi inovatif untuk performa maksimal. Ringan dan nyaman digunakan untuk berbagai jenis permukaan.',
                'harga' => 1200000,
                'stok' => 50,
                'kategori' => 'Sepatu',
            ],
            [
                'nama_produk' => 'Kaos Olahraga FlexFit',
                'deskripsi' => 'Kaos olahraga dengan bahan stretchable yang menyerap keringat. Sempurna untuk latihan intensitas tinggi.',
                'harga' => 250000,
                'stok' => 100,
                'kategori' => 'Pakaian',
            ],
            [
                'nama_produk' => 'Celana Pendek Gym Pro',
                'deskripsi' => 'Celana pendek nyaman untuk berolahraga dengan kantong multifungsi. Bahan cepat kering dan tahan lama.',
                'harga' => 320000,
                'stok' => 75,
                'kategori' => 'Pakaian',
            ],
            [
                'nama_produk' => 'Jam Tangan Fitness Tracker',
                'deskripsi' => 'Jam tangan pintar dengan fitur pelacak aktivitas, detak jantung, dan notifikasi. Tahan air hingga 50 meter.',
                'harga' => 1500000,
                'stok' => 30,
                'kategori' => 'Aksesoris',
            ],
            [
                'nama_produk' => 'Raket Tenis Carbon Pro',
                'deskripsi' => 'Raket tenis profesional dengan bahan karbon ringan. Menyediakan kontrol dan kekuatan optimal.',
                'harga' => 2000000,
                'stok' => 20,
                'kategori' => 'Perlengkapan',
            ],
            [
                'nama_produk' => 'Tas Olahraga Multi-Pocket',
                'deskripsi' => 'Tas multifungsi dengan banyak kantong untuk menyimpan perlengkapan olahraga. Bahan tahan air dan kuat.',
                'harga' => 450000,
                'stok' => 40,
                'kategori' => 'Aksesoris',
            ],
        ];

        foreach ($products as $productData) {
            Produk::create([
                'penjual_id' => $admin->id,
                'nama_produk' => $productData['nama_produk'],
                'slug' => Str::slug($productData['nama_produk']) . '-' . time() . rand(1000, 9999),
                'deskripsi' => $productData['deskripsi'],
                'harga' => $productData['harga'],
                'stok' => $productData['stok'],
                'kategori' => $productData['kategori'],
                'gambar' => null, // Will be added later for demo purposes
            ]);
        }
    }
}