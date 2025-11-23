@extends('movr.layouts.app')

@section('content')
<!-- Admin Dashboard Header -->
<section class="py-6 bg-darker-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-light-text">Dashboard Admin</h1>
        <p class="text-gray-400">Kelola produk dan pesanan Anda</p>
    </div>
</section>

<!-- Admin Dashboard Content -->
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Products -->
            <div class="bg-card-bg border border-border-color rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-dark-bg">
                        <i class="fas fa-box text-accent-green text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-400">Total Produk</p>
                        <p class="text-2xl font-bold text-light-text">12</p>
                    </div>
                </div>
            </div>
            
            <!-- Total Orders -->
            <div class="bg-card-bg border border-border-color rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-dark-bg">
                        <i class="fas fa-shopping-cart text-accent-green text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-400">Total Pesanan</p>
                        <p class="text-2xl font-bold text-light-text">24</p>
                    </div>
                </div>
            </div>
            
            <!-- Total Customers -->
            <div class="bg-card-bg border border-border-color rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-dark-bg">
                        <i class="fas fa-users text-accent-green text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-400">Total Pelanggan</p>
                        <p class="text-2xl font-bold text-light-text">42</p>
                    </div>
                </div>
            </div>
            
            <!-- Revenue -->
            <div class="bg-card-bg border border-border-color rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-dark-bg">
                        <i class="fas fa-dollar-sign text-accent-green text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-400">Pendapatan</p>
                        <p class="text-2xl font-bold text-light-text">Rp 24.500.000</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Orders -->
            <div class="bg-card-bg border border-border-color rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-light-text">Pesanan Terbaru</h2>
                    <a href="#" class="text-accent-green text-sm hover:underline">Lihat Semua</a>
                </div>
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-4 bg-dark-bg rounded-lg">
                        <div>
                            <p class="font-medium text-light-text">#ORD-001</p>
                            <p class="text-sm text-gray-400">John Doe</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-light-text">Rp 1.200.000</p>
                            <p class="text-sm text-yellow-500">Menunggu</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-dark-bg rounded-lg">
                        <div>
                            <p class="font-medium text-light-text">#ORD-002</p>
                            <p class="text-sm text-gray-400">Jane Smith</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-light-text">Rp 850.000</p>
                            <p class="text-sm text-blue-500">Diproses</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between p-4 bg-dark-bg rounded-lg">
                        <div>
                            <p class="font-medium text-light-text">#ORD-003</p>
                            <p class="text-sm text-gray-400">Robert Johnson</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-light-text">Rp 2.100.000</p>
                            <p class="text-sm text-accent-green">Selesai</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Actions -->
            <div class="bg-card-bg border border-border-color rounded-lg p-6">
                <h2 class="text-lg font-bold text-light-text mb-6">Aksi Cepat</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('admin.produk.create') }}" class="bg-dark-bg border border-border-color rounded-lg p-6 text-center hover:bg-card-bg transition lift-effect">
                        <i class="fas fa-plus-circle text-accent-green text-3xl mb-3"></i>
                        <p class="font-medium text-light-text">Tambah Produk</p>
                    </a>
                    
                    <a href="{{ route('admin.produk.index') }}" class="bg-dark-bg border border-border-color rounded-lg p-6 text-center hover:bg-card-bg transition lift-effect">
                        <i class="fas fa-list text-accent-green text-3xl mb-3"></i>
                        <p class="font-medium text-light-text">Daftar Produk</p>
                    </a>
            
                    <a href="{{ route('admin.kategori.index') }}" class="bg-dark-bg border border-border-color rounded-lg p-6 text-center hover:bg-card-bg transition lift-effect">
                        <i class="fas fa-tags text-accent-green text-3xl mb-3"></i>
                        <p class="font-medium text-light-text">Kelola Kategori</p>
                    </a>
                    
                    <a href="#" class="bg-dark-bg border border-border-color rounded-lg p-6 text-center hover:bg-card-bg transition lift-effect">
                        <i class="fas fa-file-invoice text-accent-green text-3xl mb-3"></i>
                        <p class="font-medium text-light-text">Kelola Pesanan</p>
                    </a>
                    
                    <a href="#" class="bg-dark-bg border border-border-color rounded-lg p-6 text-center hover:bg-card-bg transition lift-effect">
                        <i class="fas fa-chart-line text-accent-green text-3xl mb-3"></i>
                        <p class="font-medium text-light-text">Laporan</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection