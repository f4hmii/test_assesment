@extends('movr.layouts.app')

@section('content')
<!-- Page Header -->
<section class="py-6 bg-darker-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-light-text">Produk Favorit</h1>
        <p class="text-gray-400">{{ $favorit->total() }} produk favorit</p>
    </div>
</section>

<!-- Favorite Content -->
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($favorit->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($favorit as $item)
                    <div class="product-card lift-effect" data-product-id="{{ $item->produk->id }}">
                        <div class="p-4">
                            <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md bg-card-bg">
                                @if($item->produk->gambar)
                                    <img src="{{ asset('storage/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama_produk }}" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-700 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-500 text-4xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-4">
                                <h3 class="text-lg font-medium text-light-text">{{ $item->produk->nama_produk }}</h3>
                                <p class="mt-1 text-sm text-gray-400">{{ $item->produk->kategori }}</p>
                                <p class="mt-2 text-xl font-bold text-accent-green">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</p>
                                
                                <div class="mt-4 flex space-x-2">
                                    <form action="{{ route('keranjang.store') }}" method="POST" class="flex-1">
                                        @csrf
                                        <input type="hidden" name="produk_id" value="{{ $item->produk->id }}">
                                        <input type="hidden" name="jumlah" value="1">
                                        <button type="submit" class="w-full bg-accent-green text-dark-bg py-2 rounded-lg hover:bg-opacity-90 transition btn-scale">
                                            <i class="fas fa-shopping-cart mr-2"></i>Tambahkan
                                        </button>
                                    </form>
                                    <button type="button" class="p-2 border border-border-color rounded-lg text-light-text hover:text-accent-green transition remove-favorite" data-id="{{ $item->produk->id }}" title="Hapus dari favorit">
                                        <i class="fas fa-heart text-red-500"></i>
                                    </button>
                                </div>
                                
                                <a href="{{ route('produk.show', $item->produk->slug) }}" class="mt-2 w-full block bg-dark-bg border border-border-color text-light-text py-2 rounded-lg text-center hover:bg-card-bg transition btn-scale">
                                    <i class="fas fa-eye mr-2"></i>Lihat Produk
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-12">
                {{ $favorit->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-heart text-6xl text-gray-500 mb-4"></i>
                <h3 class="text-xl font-medium text-light-text mb-2">Tidak ada produk favorit</h3>
                <p class="text-gray-400">Produk yang Anda sukai akan muncul di sini.</p>
                <a href="{{ route('produk.index') }}" class="inline-block mt-6 bg-accent-green text-dark-bg py-3 px-6 rounded-lg font-medium hover:bg-opacity-90 transition">
                    Jelajahi Produk
                </a>
            </div>
        @endif
    </div>
</section>

<script>
function toggleFavorite(productId) {
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
        if(data.status === 'removed') {
            showNotification('✓ Produk berhasil dihapus dari favorit', 'success');
            // Remove card dari UI
            const card = document.querySelector(`[data-product-id="${productId}"]`);
            if (card) {
                card.style.opacity = '0';
                card.style.transform = 'scale(0.9)';
                setTimeout(() => {
                    location.reload();
                }, 500);
            } else {
                location.reload();
            }
        }
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

document.addEventListener('DOMContentLoaded', function() {
    // Handle remove from favorites
    const removeButtons = document.querySelectorAll('.remove-favorite');
    
    removeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.getAttribute('data-id');
            
            if (!confirm('Yakin ingin menghapus produk ini dari favorit?')) {
                return;
            }
            
            toggleFavorite(productId);
        });
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
</style>
@endsection