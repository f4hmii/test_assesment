@extends('movr.layouts.app')

@section('content')

{{-- 1. HERO SECTION: Stable Image & High Contrast --}}
<section class="relative bg-white py-12 md:py-24 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            {{-- Text Side --}}
            <div class="order-2 lg:order-1 relative z-10">
                {{-- Tagline --}}
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-10 h-[3px] bg-accent-green"></span>
                    <span class="text-sm font-bold uppercase tracking-widest text-gray-900 font-heading">
                        Run Further
                    </span>
                </div>
                
                {{-- Headline --}}
                <h1 class="text-5xl md:text-7xl font-heading font-bold text-black leading-[0.9] mb-8 uppercase tracking-tight">
                    PACE YOUR <br>
                    <span class="text-accent-green">AMBITION.</span>
                </h1>
                
                {{-- Description --}}
                <p class="text-lg text-gray-800 mb-10 leading-relaxed max-w-md font-sans font-medium">
                    Tingkatkan stamina Anda dengan koleksi running gear terbaik. Ringan, responsif, dan didesain untuk setiap kilometer yang Anda tempuh.
                </p>
                
                {{-- Buttons --}}
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('produk.index') }}" class="px-8 py-4 bg-black text-white font-heading font-bold uppercase tracking-wider rounded-lg hover:bg-accent-green hover:shadow-xl hover:shadow-green-200 transition-all transform hover:-translate-y-1">
                        Shop Running
                    </a>
                    <a href="#kategori" class="px-8 py-4 bg-transparent border-2 border-gray-200 text-black font-heading font-bold uppercase tracking-wider rounded-lg hover:border-black transition-colors">
                        Explore
                    </a>
                </div>
            </div>
            
            {{-- Image Side: FIXED URL (Gambar Lari Outdoor) --}}
            <div class="order-1 lg:order-2 relative group">
                {{-- Aksen Dekoratif --}}
                <div class="absolute inset-0 bg-gray-100 rounded-2xl transform translate-x-4 translate-y-4 -z-10 transition-transform duration-500 group-hover:translate-x-6 group-hover:translate-y-6"></div>
                
                {{-- GAMBAR UTAMA: Menggunakan Link Stabil Unsplash --}}
                <img src="https://images.unsplash.com/photo-1552674605-db6ffd4facb5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" 
                     alt="Man Running Outdoor" 
                     class="relative rounded-2xl shadow-2xl w-full object-cover h-[500px] border border-gray-100 grayscale hover:grayscale-0 transition-all duration-700">
            </div>

        </div>
    </div>
</section>

{{-- 2. FEATURES STRIP: Layout Lama, Icon Baru --}}
<div class="border-y border-gray-100 bg-white">
    <div class="max-w-7xl mx-auto px-6 py-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            {{-- Item 1 --}}
            <div class="flex items-start gap-4">
                <i class="fas fa-truck-fast text-3xl text-accent-green"></i>
                <div>
                    <h4 class="font-heading font-bold text-black uppercase text-lg">Free Shipping</h4>
                    <p class="text-xs text-gray-500 font-sans">Orders over Rp 500k</p>
                </div>
            </div>
            {{-- Item 2 --}}
            <div class="flex items-start gap-4">
                <i class="fas fa-check-circle text-3xl text-accent-green"></i>
                <div>
                    <h4 class="font-heading font-bold text-black uppercase text-lg">Authentic</h4>
                    <p class="text-xs text-gray-500 font-sans">100% Original</p>
                </div>
            </div>
            {{-- Item 3 --}}
            <div class="flex items-start gap-4">
                <i class="fas fa-box-open text-3xl text-accent-green"></i>
                <div>
                    <h4 class="font-heading font-bold text-black uppercase text-lg">Easy Returns</h4>
                    <p class="text-xs text-gray-500 font-sans">30 Days Guarantee</p>
                </div>
            </div>
            {{-- Item 4 --}}
            <div class="flex items-start gap-4">
                <i class="fas fa-lock text-3xl text-accent-green"></i>
                <div>
                    <h4 class="font-heading font-bold text-black uppercase text-lg">Secure</h4>
                    <p class="text-xs text-gray-500 font-sans">Encrypted Payment</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 3. CATEGORIES: Layout Grid Lama, Typography Baru --}}
<section id="kategori" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-12">
            <h2 class="text-4xl font-heading font-bold text-black uppercase tracking-tight mb-2">Shop By Category</h2>
            <div class="h-1 w-24 bg-accent-green mx-auto"></div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Card 1 --}}
            <a href="#" class="group relative rounded-2xl overflow-hidden h-[350px] shadow-lg">
                <img src="https://images.unsplash.com/photo-1517836357463-d25dfeac3438?q=80&w=800" class="w-full h-full object-cover transition duration-700 group-hover:scale-110 filter brightness-[0.8]">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                <div class="absolute bottom-8 left-8 text-white">
                    <h3 class="text-3xl font-heading font-bold italic uppercase mb-1">Men</h3>
                    <span class="text-accent-green text-sm font-bold tracking-wider group-hover:underline">Shop Now &rarr;</span>
                </div>
            </a>
            
            {{-- Card 2 --}}
            <a href="#" class="group relative rounded-2xl overflow-hidden h-[350px] shadow-lg">
                <img src="https://images.unsplash.com/photo-1574680096145-d05b474e2155?q=80&w=800" class="w-full h-full object-cover transition duration-700 group-hover:scale-110 filter brightness-[0.8]">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                <div class="absolute bottom-8 left-8 text-white">
                    <h3 class="text-3xl font-heading font-bold italic uppercase mb-1">Women</h3>
                    <span class="text-accent-green text-sm font-bold tracking-wider group-hover:underline">Shop Now &rarr;</span>
                </div>
            </a>

            {{-- Card 3 --}}
            <a href="#" class="group relative rounded-2xl overflow-hidden h-[350px] shadow-lg">
                <img src="https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?q=80&w=800" class="w-full h-full object-cover transition duration-700 group-hover:scale-110 filter brightness-[0.8]">
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                <div class="absolute bottom-8 left-8 text-white">
                    <h3 class="text-3xl font-heading font-bold italic uppercase mb-1">Equipment</h3>
                    <span class="text-accent-green text-sm font-bold tracking-wider group-hover:underline">Shop Now &rarr;</span>
                </div>
            </a>
        </div>
    </div>
</section>

{{-- 4. PRODUCT SECTION: Layout Card Lama (Jujur), Styling Baru --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex justify-between items-end mb-12">
            <h2 class="text-4xl font-heading font-bold text-black uppercase tracking-tight">New Arrivals</h2>
            <a href="{{ route('produk.index') }}" class="text-sm font-bold text-black border-b-2 border-black pb-1 hover:text-accent-green hover:border-accent-green transition-all">
                View All Products
            </a>
        </div>

        @if(isset($products) && $products->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-x-6 gap-y-10">
                @foreach($products as $item)
                    {{-- CARD: Tetap menggunakan card layout yang Anda suka (info di bawah) --}}
                    <div class="group flex flex-col h-full">
                        
                        {{-- Image: Rounded-xl agar tidak terlalu kotak tajam, tapi clean --}}
                        <div class="relative w-full aspect-[3/4] bg-gray-100 rounded-xl overflow-hidden mb-4 border border-gray-100">
                            {{-- Wishlist Button --}}
                            <button onclick="toggleFavorite({{ $item->id }})" id="fav-btn-{{ $item->id }}" 
                                    class="absolute top-3 right-3 z-10 w-9 h-9 flex items-center justify-center bg-white rounded-full shadow-md text-gray-400 hover:text-red-500 hover:bg-red-50 transition-all">
                                <i class="far fa-heart" id="fav-icon-{{ $item->id }}"></i>
                            </button>

                            <a href="{{ route('produk.show', $item->id) }}">
                                @if($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <i class="fas fa-image text-3xl"></i>
                                    </div>
                                @endif
                            </a>
                        </div>

                        {{-- Details Area: Clean & Direct --}}
                        <div class="flex flex-col flex-grow">
                            <div class="mb-1 text-[10px] font-bold text-gray-400 uppercase tracking-widest font-heading">
                                {{ $item->category ? $item->category->name : 'Sport' }}
                            </div>
                            
                            {{-- Nama Produk Bold Oswald --}}
                            <h3 class="text-lg font-heading font-bold text-black leading-tight mb-2 line-clamp-2 group-hover:text-accent-green transition-colors">
                                <a href="{{ route('produk.show', $item->id) }}">{{ $item->name }}</a>
                            </h3>
                            
                            <div class="mt-auto">
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-lg font-bold text-black">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                    <div class="flex items-center text-xs text-yellow-500">
                                        <i class="fas fa-star"></i> 4.9
                                    </div>
                                </div>

                                {{-- Tombol Jujur (Visible): Style diubah jadi outline hitam agar cocok dengan navbar --}}
                                <form action="{{ route('keranjang.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                    <input type="hidden" name="jumlah" value="1">
                                    <button type="submit" class="w-full py-3 px-4 rounded-lg border-2 border-black text-black font-heading font-bold uppercase tracking-wider text-xs hover:bg-black hover:text-white transition-all duration-300">
                                        Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-20 bg-gray-50 rounded-xl border-dashed border-2 border-gray-200">
                <p class="text-gray-500">Coming Soon.</p>
            </div>
        @endif
    </div>
</section>

{{-- 5. NEWSLETTER: Background Hitam (Matching Footer) --}}
<section class="py-20 bg-black text-white">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h2 class="text-3xl md:text-4xl font-heading font-bold uppercase mb-4 tracking-wide">Join The Club</h2>
        <p class="text-gray-400 mb-10 max-w-lg mx-auto font-light">
            Dapatkan diskon member, akses awal ke produk baru, dan tips latihan eksklusif.
        </p>
        
        <form class="flex flex-col sm:flex-row gap-4 max-w-lg mx-auto">
            <input type="email" placeholder="Email Address" class="flex-1 px-6 py-4 bg-white/10 border border-white/20 rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-accent-green transition">
            <button class="px-8 py-4 bg-accent-green text-white font-heading font-bold uppercase tracking-wider rounded-lg hover:bg-white hover:text-black transition-colors">
                Subscribe
            </button>
        </form>
    </div>
</section>

{{-- SCRIPT: Tidak berubah --}}
<script>
    function toggleFavorite(productId) {
        fetch('{{ route('favorit.toggle') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ product_id: product_id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 401) {
                alert('Silakan login terlebih dahulu!');
                window.location.href = '{{ route('login') }}';
                return;
            }
            if (data) updateFavoriteIcon(productId, data.isFavorited);
        });
    }

    function updateFavoriteIcon(productId, isFavorited) {
        const btn = document.getElementById(`fav-btn-${productId}`);
        const icon = document.getElementById(`fav-icon-${productId}`);

        if (isFavorited) {
            icon.classList.remove('far');
            icon.classList.add('fas', 'text-red-500');
            btn.classList.add('bg-red-50', 'text-red-500'); 
        } else {
            icon.classList.remove('fas', 'text-red-500');
            icon.classList.add('far');
            btn.classList.remove('bg-red-50', 'text-red-500');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        @auth
            const productIds = @json($products->pluck('id'));
            productIds.forEach(id => {
                fetch('{{ route('favorit.toggle') }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ product_id: id, check_only: true })
                })
                .then(res => res.json())
                .then(data => { if(data.isFavorited) updateFavoriteIcon(id, true); });
            });
        @endauth
    });
</script>

@endsection