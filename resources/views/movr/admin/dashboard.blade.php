@extends('movr.layouts.app')

@section('content')
<!-- Admin Dashboard Header -->
<section class="py-6 bg-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-black">Dashboard Admin</h1>
        <p class="text-gray-600">Kelola produk dan pesanan Anda</p>
    </div>
</section>

<!-- Admin Dashboard Content -->
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Products -->
            <div class="bg-white border border-gray-300 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-gray-100">
                        <i class="fas fa-box text-accent-green text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Produk</p>
                        <p class="text-2xl font-bold text-black">{{ $total_products }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Orders -->
            <div class="bg-white border border-gray-300 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-gray-100">
                        <i class="fas fa-shopping-cart text-accent-green text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                        <p class="text-2xl font-bold text-black">{{ $total_orders }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Customers -->
            <div class="bg-white border border-gray-300 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-gray-100">
                        <i class="fas fa-users text-accent-green text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Pelanggan</p>
                        <p class="text-2xl font-bold text-black">{{ $total_customers }}</p>
                    </div>
                </div>
            </div>

            <!-- Revenue -->
            <div class="bg-white border border-gray-300 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-gray-100">
                        <i class="fas fa-dollar-sign text-accent-green text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Pendapatan</p>
                        <p class="text-2xl font-bold text-black">Rp {{ number_format($total_revenue, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Orders -->
            <div class="bg-white border border-gray-300 rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-black">Pesanan Terbaru</h2>
                    <a href="{{ route('admin.orders.index') }}" class="text-accent-green text-sm hover:underline">Lihat Semua</a>
                </div>

                <div class="space-y-4">
                    @forelse($recent_orders as $order)
                    <div class="flex items-center justify-between p-4 bg-gray-100 rounded-lg">
                        <div>
                            <p class="font-medium text-black">#{{ $order->midtrans_order_id ?? $order->id }}</p>
                            <p class="text-sm text-gray-600">{{ $order->user->name ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-black">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            <p class="text-sm
                                @if($order->status == 'paid') text-accent-green
                                @elseif($order->status == 'pending') text-yellow-600
                                @elseif($order->status == 'cancelled') text-red-500
                                @elseif($order->status == 'processing') text-blue-600
                                @else text-gray-600 @endif">
                                {{ ucfirst($order->status) }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-6">
                        <p class="text-gray-600">Belum ada pesanan</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white border border-gray-300 rounded-lg p-6">
                <h2 class="text-lg font-bold text-black mb-6">Aksi Cepat</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <a href="{{ route('admin.produk.create') }}" class="bg-gray-100 border border-gray-300 rounded-lg p-6 text-center hover:bg-gray-200 transition lift-effect">
                        <i class="fas fa-plus-circle text-accent-green text-3xl mb-3"></i>
                        <p class="font-medium text-black">Tambah Produk</p>
                    </a>

                    <a href="{{ route('admin.produk.index') }}" class="bg-gray-100 border border-gray-300 rounded-lg p-6 text-center hover:bg-gray-200 transition lift-effect">
                        <i class="fas fa-list text-accent-green text-3xl mb-3"></i>
                        <p class="font-medium text-black">Daftar Produk</p>
                    </a>

                    <a href="{{ route('admin.kategori.index') }}" class="bg-gray-100 border border-gray-300 rounded-lg p-6 text-center hover:bg-gray-200 transition lift-effect">
                        <i class="fas fa-tags text-accent-green text-3xl mb-3"></i>
                        <p class="font-medium text-black">Kelola Kategori</p>
                    </a>

                    <a href="{{ route('admin.orders.index') }}" class="bg-gray-100 border border-gray-300 rounded-lg p-6 text-center hover:bg-gray-200 transition lift-effect">
                        <i class="fas fa-file-invoice text-accent-green text-3xl mb-3"></i>
                        <p class="font-medium text-black">Kelola Pesanan</p>
                    </a>

                    <a href="{{ route('admin.dashboard') }}" class="bg-gray-100 border border-gray-300 rounded-lg p-6 text-center hover:bg-gray-200 transition lift-effect">
                        <i class="fas fa-chart-line text-accent-green text-3xl mb-3"></i>
                        <p class="font-medium text-black">Laporan</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection