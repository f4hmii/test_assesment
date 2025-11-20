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
                                            @auth
                                                <button type="button" onclick="toggleFavorite({{ $item->id }})" class="p-2 border border-border-color rounded-lg text-light-text hover:text-accent-green transition favorite-btn" data-id="{{ $item->id }}" data-favorited="false" title="Tambahkan ke favorit">
                                                    <i class="fas fa-heart"></i>
                                                </button>
                                            @endauth
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

<script>
function toggleFavorite(productId) {
    console.log('Toggle favorite for product:', productId);
    
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch('{{ route('favorit.toggle') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({
            produk_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response:', data);
        const buttons = document.querySelectorAll(`[data-id="${productId}"]`);
        buttons.forEach(btn => {
            const icon = btn.querySelector('i');
            if (data.status === 'added') {
                icon.style.color = '#10b981 !important';
                icon.style.fontWeight = '900 !important';
                btn.classList.add('favorited');
                showNotification('✓ Ditambahkan ke favorit', 'success');
            } else if (data.status === 'removed') {
                icon.style.color = 'currentColor !important';
                icon.style.fontWeight = '400 !important';
                btn.classList.remove('favorited');
                showNotification('✓ Dihapus dari favorit', 'info');
            }
        });
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('✗ Terjadi kesalahan', 'error');
    });
}

function showNotification(message, type = 'info') {
    const bgColor = {
        'success': 'bg-accent-green',
        'info': 'bg-blue-500',
        'error': 'bg-red-500'
    }[type] || 'bg-blue-500';

    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 ${bgColor} text-white px-6 py-3 rounded-lg shadow-lg z-50`;
    notification.textContent = message;
    notification.style.animation = 'fadeIn 0.3s ease-in';
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'fadeOut 0.3s ease-out';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Check favorite status on page load
document.addEventListener('DOMContentLoaded', function() {
    const favoriteButtons = document.querySelectorAll('.favorite-btn');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    favoriteButtons.forEach(button => {
        const productId = button.getAttribute('data-id');
        
        fetch('{{ route('favorit.toggle') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({
                produk_id: productId,
                check_only: true
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.isFavorited) {
                const icon = button.querySelector('i');
                icon.style.color = '#10b981 !important';
                icon.style.fontWeight = '900 !important';
                button.classList.add('favorited');
            }
        })
        .catch(error => console.error('Error:', error));
    });
});
</script>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes fadeOut {
    from {
        opacity: 1;
        transform: translateY(0);
    }
    to {
        opacity: 0;
        transform: translateY(-20px);
    }
}

.favorite-btn.favorited i {
    color: #10b981 !important;
    font-weight: 900 !important;
}
</style>
@endsection