@extends('movr.layouts.app')

@section('content')

{{-- HEADER SECTION --}}
<div class="bg-white pt-10 pb-6 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end gap-4">
            <div>
                <span class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 block">Catalog</span>
                <h1 class="text-4xl md:text-5xl font-heading font-bold text-black uppercase tracking-tight">
                    All Products
                </h1>
            </div>
            
            {{-- Breadcrumb / Info Count --}}
            <div class="text-sm text-gray-500 font-medium">
                Showing <span class="text-black font-bold">{{ $products->count() }}</span> of {{ $products->total() }} results
            </div>
        </div>
    </div>
</div>

<section class="py-12 bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12">

            {{-- 1. SIDEBAR FILTER (Sticky) --}}
            <aside class="w-full lg:w-64 flex-shrink-0">
                <div class="sticky top-24 space-y-8">
                    
                    {{-- Filter Group: Category --}}
                    <div>
                        <h3 class="font-heading font-bold text-black text-lg uppercase mb-4 border-b-2 border-black pb-2 inline-block">
                            Categories
                        </h3>
                        <ul class="space-y-3">
                            {{-- Option: All --}}
                            <li>
                                <a href="{{ route('produk.index') }}" 
                                   class="group flex items-center justify-between text-sm transition-all duration-200 
                                   {{ !request('kategori') ? 'text-accent-green font-bold pl-2 border-l-2 border-accent-green' : 'text-gray-500 hover:text-black' }}">
                                    <span>All Categories</span>
                                    @if(!request('kategori')) <i class="fas fa-check text-xs"></i> @endif
                                </a>
                            </li>

                            {{-- Dynamic Categories --}}
                            @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('produk.index', ['kategori' => $cat->slug]) }}" 
                                   class="group flex items-center justify-between text-sm transition-all duration-200
                                   {{ request('kategori') == $cat->slug ? 'text-accent-green font-bold pl-2 border-l-2 border-accent-green' : 'text-gray-500 hover:text-black' }}">
                                    <span>{{ $cat->name }}</span>
                                    @if(request('kategori') == $cat->slug) <i class="fas fa-check text-xs"></i> @endif
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Filter Group: Sort (Visual Only - Bisa Anda fungsikan nanti) --}}
                    <div>
                        <h3 class="font-heading font-bold text-black text-lg uppercase mb-4 border-b-2 border-black pb-2 inline-block">
                            Sort By
                        </h3>
                        <select onchange="location = this.value;" class="w-full bg-gray-50 border border-gray-200 text-gray-700 text-sm rounded-lg focus:ring-black focus:border-black block p-2.5 outline-none">
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'newest']) }}">Newest Arrivals</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_low']) }}">Price: Low to High</option>
                            <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_high']) }}">Price: High to Low</option>
                        </select>
                    </div>

                    {{-- Promo Banner Kecil di Sidebar --}}
                    <div class="bg-black text-white p-6 rounded-xl text-center hidden lg:block">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Member Only</p>
                        <h4 class="font-heading font-bold text-2xl uppercase mb-4">Save 20%</h4>
                        <a href="#" class="text-xs border-b border-white hover:text-accent-green hover:border-accent-green transition pb-1">Join Now</a>
                    </div>
                </div>
            </aside>

            {{-- 2. PRODUCT GRID --}}
            <div class="flex-1">
                @if($products->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-x-6 gap-y-10">
                        @foreach($products as $item)
                            {{-- CARD DESIGN (Sama dengan Home) --}}
                            <div class="group flex flex-col h-full">
                                
                                {{-- Image Area --}}
                                <div class="relative w-full aspect-[3/4] bg-gray-100 rounded-xl overflow-hidden mb-4 border border-gray-100">
                                    {{-- Wishlist --}}
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

                                {{-- Details --}}
                                <div class="flex flex-col flex-grow">
                                    <div class="mb-1 text-[10px] font-bold text-gray-400 uppercase tracking-widest font-heading">
                                        {{ $item->category ? $item->category->name : 'Sport' }}
                                    </div>
                                    
                                    <h3 class="text-base font-heading font-bold text-black leading-tight mb-2 line-clamp-2 group-hover:text-accent-green transition-colors">
                                        <a href="{{ route('produk.show', $item->id) }}">{{ $item->name }}</a>
                                    </h3>
                                    
                                    <div class="mt-auto">
                                        <div class="flex items-center justify-between mb-4">
                                            <span class="text-lg font-bold text-black">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                            <div class="flex items-center text-xs text-yellow-500">
                                                <i class="fas fa-star"></i> 4.9
                                            </div>
                                        </div>

                                        {{-- Actions --}}
                                        <form action="{{ route('keranjang.store') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                            <input type="hidden" name="jumlah" value="1">
                                            <button type="submit" class="w-full py-3 px-4 rounded-lg border-2 border-black text-black font-heading font-bold uppercase tracking-wider text-[10px] sm:text-xs hover:bg-black hover:text-white transition-all duration-300">
                                                Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination (Custom Style) --}}
                    <div class="mt-16 flex justify-center">
                        {{ $products->links() }} 
                        {{-- Catatan: Jika ingin pagination bergaya kotak hitam putih, 
                             Anda perlu publish vendor pagination Laravel dan edit file Tailwind-nya. 
                             Atau biarkan default Tailwind Laravel yang sudah rapi. --}}
                    </div>

                @else
                    {{-- Empty State --}}
                    <div class="flex flex-col items-center justify-center py-24 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mb-4 text-gray-400">
                            <i class="fas fa-search text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-heading font-bold text-black mb-2 uppercase">No Products Found</h3>
                        <p class="text-gray-500 mb-6">Try adjusting your filters or check back later.</p>
                        <a href="{{ route('produk.index') }}" class="text-sm font-bold text-black border-b border-black hover:text-accent-green hover:border-accent-green transition">
                            Clear Filters
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Script Favorit (Wajib ada agar tombol heart berfungsi) --}}
<script>
    function toggleFavorite(productId) {
        fetch('{{ route('favorit.toggle') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ product_id: productId })
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