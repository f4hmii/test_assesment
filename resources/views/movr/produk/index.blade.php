@extends('movr.layouts.app')

@section('content')
<!-- Page Header -->
<section class="py-12 bg-darker-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-light-text">Semua Produk</h1>
        <p class="mt-2 text-gray-400">Temukan produk sporty terbaik untuk gaya hidup aktif Anda</p>
    </div>
</section>

<!-- Product Listing -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row">
            <!-- Filters Sidebar -->
            <div class="md:w-1/4 mb-8 md:mb-0 md:pr-8">
                <div class="bg-card-bg border border-border-color rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-light-text mb-4">Filter</h3>
                    
                    <div class="mb-6">
                        <h4 class="font-medium text-light-text mb-2">Kategori</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-400 hover:text-accent-green transition">Semua Kategori</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-accent-green transition">Sepatu</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-accent-green transition">Pakaian</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-accent-green transition">Aksesoris</a></li>
                            <li><a href="#" class="text-gray-400 hover:text-accent-green transition">Perlengkapan</a></li>
                        </ul>
                    </div>
                    
                    <div class="mb-6">
                        <h4 class="font-medium text-light-text mb-2">Harga</h4>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded bg-card-bg border-border-color text-accent-green focus:ring-accent-green">
                                <span class="ml-2 text-gray-400">Rp 0 - Rp 500.000</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded bg-card-bg border-border-color text-accent-green focus:ring-accent-green">
                                <span class="ml-2 text-gray-400">Rp 500.000 - Rp 1.000.000</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" class="rounded bg-card-bg border-border-color text-accent-green focus:ring-accent-green">
                                <span class="ml-2 text-gray-400">Rp 1.000.000+</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Products Grid -->
            <div class="md:w-3/4">
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-400">{{ $produk->total() }} produk ditemukan</p>
                    <div>
                        <select class="bg-card-bg border border-border-color rounded-lg px-4 py-2 text-light-text">
                            <option>Terbaru</option>
                            <option>Harga Terendah</option>
                            <option>Harga Tertinggi</option>
                            <option>Terlaris</option>
                        </select>
                    </div>
                </div>
                
                @if($produk->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($produk as $item)
                            <div class="product-card lift-effect">
                                <div class="p-4">
                                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md bg-card-bg">
                                        @if($item->gambar)
                                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_produk }}" class="w-full h-48 object-cover">
                                        @else
                                            <div class="w-full h-48 bg-gray-700 flex items-center justify-center">
                                                <i class="fas fa-image text-gray-500 text-4xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mt-4">
                                        <h3 class="text-lg font-medium text-light-text">{{ $item->nama_produk }}</h3>
                                        <p class="mt-1 text-sm text-gray-400">{{ $item->kategori }}</p>
                                        <p class="mt-2 text-xl font-bold text-accent-green">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                                        
                                        <div class="mt-4 flex space-x-2">
                                            <form action="{{ route('keranjang.store') }}" method="POST" class="flex-1">
                                                @csrf
                                                <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                                <input type="hidden" name="jumlah" value="1">
                                                <button type="submit" class="w-full bg-accent-green text-dark-bg py-2 rounded-lg hover:bg-opacity-90 transition btn-scale">
                                                    <i class="fas fa-shopping-cart mr-2"></i>Tambahkan
                                                </button>
                                            </form>
                                            <a href="{{ route('produk.show', $item->slug) }}" class="w-full bg-dark-bg border border-border-color text-light-text py-2 rounded-lg text-center hover:bg-card-bg transition btn-scale">
                                                <i class="fas fa-eye mr-2"></i>Lihat
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $produk->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-box text-6xl text-gray-500 mb-4"></i>
                        <h3 class="text-xl font-medium text-light-text mb-2">Tidak ada produk ditemukan</h3>
                        <p class="text-gray-400">Silakan coba filter yang berbeda.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection