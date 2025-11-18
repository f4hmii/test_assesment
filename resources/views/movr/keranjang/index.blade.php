@extends('movr.layouts.app')

@section('content')
<!-- Page Header -->
<section class="py-6 bg-darker-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-light-text">Keranjang Belanja</h1>
    </div>
</section>

<!-- Cart Content -->
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($keranjangItems->count() > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Cart Items -->
                <div class="lg:w-2/3">
                    <div class="bg-card-bg border border-border-color rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-border-color">
                            <thead class="bg-dark-bg">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Produk</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Harga</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Jumlah</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Subtotal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-color">
                                @foreach($keranjangItems as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-20 w-20 bg-card-bg rounded-md overflow-hidden border border-border-color">
                                                @if($item->produk->gambar)
                                                    <img src="{{ asset('storage/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama_produk }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <i class="fas fa-image text-gray-500"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-light-text">{{ $item->produk->nama_produk }}</div>
                                                <div class="text-sm text-gray-400">{{ $item->produk->kategori }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-light-text">Rp {{ number_format($item->harga_saat_ini, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('keranjang.update', $item->id) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" max="{{ $item->produk->stok }}" class="w-16 bg-dark-bg border border-border-color rounded-lg px-3 py-1 text-light-text text-center">
                                            <button type="submit" class="ml-2 text-accent-green hover:text-accent-green">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-light-text">Rp {{ number_format($item->jumlah * $item->harga_saat_ini, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <form action="{{ route('keranjang.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-400">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4 flex">
                        <a href="{{ route('produk.index') }}" class="flex-1 bg-dark-bg border border-border-color text-light-text py-2 px-4 rounded-lg text-center hover:bg-card-bg transition">
                            <i class="fas fa-arrow-left mr-2"></i>Lanjutkan Belanja
                        </a>
                    </div>
                </div>
                
                <!-- Order Summary -->
                <div class="lg:w-1/3">
                    <div class="bg-card-bg border border-border-color rounded-lg p-6">
                        <h2 class="text-lg font-bold text-light-text mb-4">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between">
                                <span class="text-light-text">Subtotal</span>
                                <span class="text-light-text">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-light-text">Biaya Pengiriman</span>
                                <span class="text-light-text">Rp 0</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-light-text">Pajak</span>
                                <span class="text-light-text">Rp {{ number_format($total * 0.1, 0, ',', '.') }}</span>
                            </div>
                            <div class="border-t border-border-color pt-4">
                                <div class="flex justify-between">
                                    <span class="text-lg font-bold text-light-text">Total</span>
                                    <span class="text-lg font-bold text-accent-green">Rp {{ number_format($total * 1.1, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('checkout.index') }}" class="w-full mt-6 bg-accent-green text-dark-bg py-3 px-4 rounded-lg text-center font-medium hover:bg-opacity-90 transition btn-scale">
                            <i class="fas fa-shopping-bag mr-2"></i>Lanjut ke Checkout
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-shopping-cart text-6xl text-gray-500 mb-4"></i>
                <h3 class="text-xl font-medium text-light-text mb-2">Keranjang Anda kosong</h3>
                <p class="text-gray-400 mb-6">Produk yang Anda tambahkan akan muncul di sini</p>
                <a href="{{ route('produk.index') }}" class="inline-block bg-accent-green text-dark-bg py-2 px-6 rounded-lg font-medium hover:bg-opacity-90 transition">
                    Belanja Sekarang
                </a>
            </div>
        @endif
    </div>
</section>
@endsection