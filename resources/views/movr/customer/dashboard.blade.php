@extends('movr.layouts.app')

@section('content')
<!-- Dashboard Header -->
<section class="py-12 bg-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-black">Dashboard Pelanggan</h1>
        <p class="mt-2 text-gray-600">Kelola pesanan dan informasi akun Anda</p>
    </div>
</section>

<!-- Dashboard Stats -->
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Orders -->
            <div class="bg-white border border-gray-300 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-gray-100">
                        <i class="fas fa-shopping-bag text-accent-green text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                        <p class="text-2xl font-bold text-black">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>

            <!-- Completed Orders -->
            <div class="bg-white border border-gray-300 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-gray-100">
                        <i class="fas fa-check-circle text-accent-green text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Selesai</p>
                        <p class="text-2xl font-bold text-black">{{ $completedOrders }}</p>
                    </div>
                </div>
            </div>

            <!-- Pending Orders -->
            <div class="bg-white border border-gray-300 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-gray-100">
                        <i class="fas fa-clock text-accent-green text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Dalam Proses</p>
                        <p class="text-2xl font-bold text-black">{{ $pendingOrders }}</p>
                    </div>
                </div>
            </div>

            <!-- Total Spent -->
            <div class="bg-white border border-gray-300 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-lg bg-gray-100">
                        <i class="fas fa-dollar-sign text-accent-green text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Belanja</p>
                        <p class="text-2xl font-bold text-black">Rp {{ number_format($totalSpent, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders -->
        <div class="bg-white border border-gray-300 rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-black">Riwayat Pesanan Terbaru</h2>
            </div>

            @if($orders->count() > 0)
                <div class="space-y-6">
                    @foreach($orders as $order)
                    <div class="border border-gray-300 rounded-lg p-6">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                            <div>
                                <div class="flex items-center gap-4 mb-2">
                                    <h3 class="text-lg font-bold text-black">#{{ $order->midtrans_order_id ?? $order->id }}</h3>
                                    <span class="px-3 py-1 rounded-full text-sm font-medium 
                                        @switch($order->status)
                                            @case('paid')
                                                bg-green-100 text-green-800
                                                @break
                                            @case('pending')
                                                bg-yellow-100 text-yellow-800
                                                @break
                                            @case('cancelled')
                                                bg-red-100 text-red-800
                                                @break
                                            @case('processing')
                                                bg-blue-100 text-blue-800
                                                @break
                                            @case('shipped')
                                                bg-indigo-100 text-indigo-800
                                                @break
                                            @case('delivered')
                                                bg-purple-100 text-purple-800
                                                @break
                                            @default
                                                bg-gray-100 text-gray-800
                                        @endswitch">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <p class="text-gray-600 text-sm mb-2">{{ $order->created_at->format('d M Y H:i') }}</p>
                                <p class="text-black font-medium">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-2">
                                <a href="{{ route('customer.order.show', $order->id) }}" class="px-4 py-2 bg-white border border-gray-300 text-black rounded-lg hover:bg-gray-100 transition">
                                    Detail Pesanan
                                </a>
                                @if($order->status === 'paid')
                                <a href="{{ $order->payment_url }}" class="px-4 py-2 bg-accent-green text-white rounded-lg hover:bg-accent-green/90 transition">
                                    Lihat Pembayaran
                                </a>
                                @endif
                            </div>
                        </div>

                        <!-- Order Items Preview -->
                        <div class="mt-4 pt-4 border-t border-gray-300">
                            <p class="text-sm font-medium text-gray-600 mb-2">Item dalam pesanan:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($order->items->take(3) as $item)
                                <div class="flex items-center bg-gray-100 rounded-lg p-2">
                                    @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-10 h-10 rounded object-cover mr-2">
                                    @else
                                    <div class="w-10 h-10 rounded bg-gray-200 flex items-center justify-center mr-2">
                                        <i class="fas fa-image text-gray-500"></i>
                                    </div>
                                    @endif
                                    <div>
                                        <p class="text-xs font-medium text-black">{{ Str::limit($item->product->name ?? 'Produk Tidak Ditemukan', 20) }}</p>
                                        <p class="text-xs text-gray-600">Qty: {{ $item->quantity }}</p>
                                    </div>
                                </div>
                                @endforeach
                                
                                @if($order->items->count() > 3)
                                <div class="flex items-center bg-gray-100 rounded-lg p-2">
                                    <span class="text-xs text-gray-600">+{{ $order->items->count() - 3 }} lainnya</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <i class="fas fa-shopping-bag text-5xl text-gray-400 mb-4"></i>
                    <h3 class="text-xl font-bold text-black mb-2">Belum ada pesanan</h3>
                    <p class="text-gray-600 mb-6">Pesanan Anda akan muncul di sini setelah Anda melakukan pembelian</p>
                    <a href="{{ route('home') }}" class="inline-block bg-accent-green text-white py-3 px-8 rounded-full font-bold hover:bg-accent-green/90 transition">
                        Mulai Belanja
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection