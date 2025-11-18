@extends('movr.layouts.app')

@section('content')
<!-- Breadcrumb -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="text-gray-400 hover:text-accent-green transition">Beranda</a>
            </li>
            <li>
                <i class="fas fa-chevron-right text-gray-500 text-sm mx-2"></i>
            </li>
            <li>
                <a href="{{ route('produk.index') }}" class="text-gray-400 hover:text-accent-green transition">Produk</a>
            </li>
            <li>
                <i class="fas fa-chevron-right text-gray-500 text-sm mx-2"></i>
            </li>
            <li class="text-light-text">{{ $produk->nama_produk }}</li>
        </ol>
    </nav>
</div>

<!-- Product Detail -->
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-12">
            <!-- Product Images -->
            <div class="lg:w-1/2">
                <div class="bg-card-bg border border-border-color rounded-lg p-4">
                    <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-lg bg-dark-bg">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-full h-96 object-contain">
                        @else
                            <div class="w-full h-96 bg-gray-700 flex items-center justify-center">
                                <i class="fas fa-image text-gray-500 text-6xl"></i>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Thumbnail Images (if available) -->
                <div class="grid grid-cols-4 gap-4 mt-4">
                    @if($produk->gambar)
                        <div class="border border-border-color rounded-lg p-2 bg-card-bg">
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-full h-20 object-cover rounded">
                        </div>
                    @else
                        <div class="border border-border-color rounded-lg p-2 bg-card-bg flex items-center justify-center">
                            <i class="fas fa-image text-gray-500 text-2xl"></i>
                        </div>
                    @endif
                    <!-- Add more thumbnails if available -->
                    <div class="border border-border-color rounded-lg p-2 bg-card-bg opacity-50">
                        <i class="fas fa-image text-gray-500 text-2xl"></i>
                    </div>
                    <div class="border border-border-color rounded-lg p-2 bg-card-bg opacity-50">
                        <i class="fas fa-image text-gray-500 text-2xl"></i>
                    </div>
                    <div class="border border-border-color rounded-lg p-2 bg-card-bg opacity-50">
                        <i class="fas fa-image text-gray-500 text-2xl"></i>
                    </div>
                </div>
            </div>
            
            <!-- Product Info -->
            <div class="lg:w-1/2">
                <h1 class="text-3xl font-bold text-light-text">{{ $produk->nama_produk }}</h1>
                
                <div class="flex items-center mt-2">
                    <div class="flex">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-accent-green"></i>
                        @endfor
                    </div>
                    <span class="ml-2 text-gray-400">({{ $produk->ulasan->count() }} ulasan)</span>
                </div>
                
                <div class="mt-6">
                    <p class="text-3xl font-bold text-accent-green">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    <p class="mt-2 text-gray-400">Stok: 
                        <span class="{{ $produk->stok > 0 ? 'text-accent-green' : 'text-red-500' }}">
                            {{ $produk->stok > 0 ? $produk->stok . ' tersedia' : 'Habis' }}
                        </span>
                    </p>
                </div>
                
                <div class="mt-6">
                    <p class="text-light-text">Kategori: <span class="text-accent-green">{{ $produk->kategori }}</span></p>
                    <p class="mt-2 text-gray-400">{{ $produk->deskripsi }}</p>
                </div>
                
                <!-- Actions -->
                <div class="mt-8">
                    <form action="{{ route('keranjang.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                        
                        <div class="flex items-center mb-4">
                            <label class="mr-3 text-light-text">Jumlah:</label>
                            <input type="number" name="jumlah" value="1" min="1" max="{{ $produk->stok }}" class="w-20 bg-card-bg border border-border-color rounded-lg px-3 py-2 text-light-text">
                        </div>
                        
                        <div class="flex flex-wrap gap-4">
                            <button type="submit" class="flex-1 bg-accent-green text-dark-bg py-3 px-6 rounded-lg font-medium hover:bg-opacity-90 transition btn-scale">
                                <i class="fas fa-shopping-cart mr-2"></i>Masukkan Keranjang
                            </button>
                            
                            <a href="{{ route('checkout.index') }}" class="flex-1 bg-dark-bg border border-border-color text-light-text py-3 px-6 rounded-lg font-medium hover:bg-card-bg transition btn-scale">
                                <i class="fas fa-bolt mr-2"></i>Beli Sekarang
                            </a>
                            
                            <button type="button" id="favorite-btn" class="p-3 border border-border-color rounded-lg text-light-text hover:text-accent-green transition btn-scale">
                                <i class="fas fa-heart"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Seller Info -->
                <div class="mt-8 pt-6 border-t border-border-color">
                    <p class="text-gray-400">Dijual oleh: <span class="text-accent-green">{{ $produk->penjual->name ?? 'Admin' }}</span></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Reviews Section -->
<section class="py-8 bg-darker-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-light-text mb-6">Ulasan Produk</h2>
        
        @auth
            <div class="bg-card-bg border border-border-color rounded-lg p-6 mb-8">
                <h3 class="text-lg font-medium text-light-text mb-4">Tulis Ulasan Anda</h3>
                <form action="{{ route('ulasan.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                    
                    <div class="mb-4">
                        <label class="block text-light-text mb-2">Rating</label>
                        <div class="flex">
                            <input type="radio" id="star5" name="rating" value="5" class="hidden" required>
                            <label for="star5" class="rating-star cursor-pointer text-2xl px-1">★</label>
                            <input type="radio" id="star4" name="rating" value="4" class="hidden">
                            <label for="star4" class="rating-star cursor-pointer text-2xl px-1">★</label>
                            <input type="radio" id="star3" name="rating" value="3" class="hidden">
                            <label for="star3" class="rating-star cursor-pointer text-2xl px-1">★</label>
                            <input type="radio" id="star2" name="rating" value="2" class="hidden">
                            <label for="star2" class="rating-star cursor-pointer text-2xl px-1">★</label>
                            <input type="radio" id="star1" name="rating" value="1" class="hidden">
                            <label for="star1" class="rating-star cursor-pointer text-2xl px-1">★</label>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label for="komentar" class="block text-light-text mb-2">Komentar</label>
                        <textarea name="komentar" id="komentar" rows="4" class="w-full bg-card-bg border border-border-color rounded-lg px-4 py-2 text-light-text focus:outline-none focus:ring-2 focus:ring-accent-green" placeholder="Tulis ulasan Anda..."></textarea>
                    </div>
                    
                    <button type="submit" class="bg-accent-green text-dark-bg px-6 py-2 rounded-lg font-medium hover:bg-opacity-90 transition">Kirim Ulasan</button>
                </form>
            </div>
        @endauth
        
        <div class="space-y-6">
            @forelse($ulasan as $review)
                <div class="bg-card-bg border border-border-color rounded-lg p-6">
                    <div class="flex items-start">
                        <div class="flex-1">
                            <div class="flex items-center justify-between">
                                <h4 class="font-medium text-light-text">{{ $review->pembeli->name ?? 'Pembeli' }}</h4>
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <i class="fas fa-star text-accent-green"></i>
                                        @else
                                            <i class="fas fa-star text-gray-500"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <p class="text-gray-400 text-sm mt-1">{{ $review->created_at->format('d M Y') }}</p>
                            <p class="mt-3 text-gray-300">{{ $review->komentar ?? 'Tidak ada komentar' }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <i class="fas fa-comment-slash text-4xl text-gray-500 mb-4"></i>
                    <p class="text-gray-400">Belum ada ulasan untuk produk ini.</p>
                </div>
            @endforelse
        </div>
        
        <!-- Pagination for reviews -->
        <div class="mt-8">
            {{ $ulasan->links() }}
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Favorite button functionality
    const favoriteBtn = document.getElementById('favorite-btn');
    if(favoriteBtn) {
        favoriteBtn.addEventListener('click', function() {
            fetch('{{ route('favorit.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    produk_id: {{ $produk->id }}
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'added') {
                    favoriteBtn.innerHTML = '<i class="fas fa-heart text-accent-green"></i>';
                    alert('Produk ditambahkan ke favorit!');
                } else {
                    favoriteBtn.innerHTML = '<i class="fas fa-heart"></i>';
                    alert('Produk dihapus dari favorit!');
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
    
    // Star rating functionality
    const stars = document.querySelectorAll('.rating-star');
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = this.getAttribute('for').replace('star', '');
            // Update all stars up to the clicked one
            stars.forEach((s, index) => {
                if(index < value) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
            // Set the hidden radio button
            document.getElementById('star' + value).checked = true;
        });
    });
});
</script>
@endsection