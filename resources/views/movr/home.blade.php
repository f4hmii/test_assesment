@extends('movr.layouts.app')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-darker-bg to-dark-bg py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center">
            <div class="md:w-1/2 mb-10 md:mb-0">
                <h1 class="text-5xl font-bold text-light-text mb-4">Tingkatkan Performa <span class="text-accent-green">Mu</span></h1>
                <p class="text-xl text-gray-300 mb-8">Temukan koleksi terbaru dari produk sporty premium yang didesain untuk gaya hidup aktif dan performa maksimal.</p>
                <div class="flex space-x-4">
                    <a href="{{ route('produk.index') }}" class="bg-accent-green text-dark-bg px-8 py-3 rounded-full font-semibold hover:bg-opacity-90 transition transform hover:-translate-y-1">Belanja Sekarang</a>
                    <a href="#featured-products" class="border border-accent-green text-accent-green px-8 py-3 rounded-full font-semibold hover:bg-accent-green hover:text-dark-bg transition">Lihat Produk</a>
                </div>
            </div>
            <div class="md:w-1/2 flex justify-center">
                <div class="relative">
                    <div class="w-80 h-80 bg-gradient-to-br from-accent-green to-accent-blue rounded-full flex items-center justify-center">
                        <div class="w-64 h-64 bg-dark-bg rounded-full flex items-center justify-center">
                            <i class="fas fa-running text-accent-green text-8xl"></i>
                        </div>
                    </div>
                    <div class="absolute -bottom-4 -right-4 bg-card-bg border border-border-color rounded-xl p-4 shadow-xl">
                        <p class="text-accent-green font-bold">Kualitas Premium</p>
                        <p class="text-light-text text-sm">Teruji & Terpercaya</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section id="featured-products" class="py-16 bg-dark-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-light-text mb-4">Produk Unggulan</h2>
            <p class="text-gray-400 max-w-2xl mx-auto">Temukan produk-produk terbaik yang paling banyak diminati oleh pelanggan kami.</p>
        </div>
        
        @if($produk->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
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
                                        <i class="fas fa-eye mr-2"></i>Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-box text-6xl text-gray-500 mb-4"></i>
                <h3 class="text-xl font-medium text-light-text mb-2">Tidak ada produk tersedia</h3>
                <p class="text-gray-400">Produk akan segera ditambahkan. Silakan kembali lagi nanti.</p>
            </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-r from-accent-green to-accent-blue">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-dark-bg mb-4">Siap Tingkatkan Performa Mu?</h2>
        <p class="text-xl text-dark-bg mb-8 max-w-2xl mx-auto">Bergabunglah dengan ribuan pelanggan lainnya yang telah meningkatkan gaya hidup sporty mereka.</p>
        <a href="{{ route('produk.index') }}" class="bg-dark-bg text-accent-green px-8 py-3 rounded-full font-semibold hover:bg-darker-bg transition">Mulai Belanja</a>
    </div>
</section>
@endsection