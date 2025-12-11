@extends('movr.layouts.app')

@section('content')
    <!-- Breadcrumb -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 transition">Beranda</a>
                </li>
                <li>
                    <i class="fas fa-chevron-right text-gray-400 text-sm mx-2"></i>
                </li>
                <li>
                    <a href="{{ route('produk.index') }}" class="text-gray-600 hover:text-gray-900 transition">Produk</a>
                </li>
                <li>
                    <i class="fas fa-chevron-right text-gray-400 text-sm mx-2"></i>
                </li>
                <li class="text-gray-900">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>

    <!-- Product Detail -->
    <section class="py-8 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row gap-12">
                <!-- Product Images -->
                <div class="lg:w-1/2">
                    <div class="bg-white border border-gray-300 p-4 rounded-lg">
                        <div class="aspect-w-2 aspect-h-2 overflow-hidden rounded">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class=" object-contain">
                            @else
                                <div class="w-full h-96 bg-gray-100 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400 text-6xl"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Thumbnail Images (if available) -->
                    <div class="grid grid-cols-4 gap-4 mt-4">
                        @if ($product->image)
                            <div class="border border-gray-300 rounded-lg p-2 bg-white">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-20 object-cover rounded">
                            </div>
                        @else
                            <div
                                class="border border-gray-300 rounded-lg p-2 bg-white flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-2xl"></i>
                            </div>
                        @endif
                        <!-- Add more thumbnails if available -->
                        <div class="border border-gray-300 rounded-lg p-2 bg-white opacity-50">
                            <i class="fas fa-image text-gray-400 text-2xl"></i>
                        </div>
                        <div class="border border-gray-300 rounded-lg p-2 bg-white opacity-50">
                            <i class="fas fa-image text-gray-400 text-2xl"></i>
                        </div>
                        <div class="border border-gray-300 rounded-lg p-2 bg-white opacity-50">
                            <i class="fas fa-image text-gray-400 text-2xl"></i>
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="lg:w-1/2">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>

                    <div class="flex items-center mt-2">
                        <div class="flex">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star text-yellow-400"></i>
                            @endfor
                        </div>
                        <span class="ml-2 text-gray-600">({{ $product->ulasan->count() }} ulasan)</span>
                    </div>

                    <div class="mt-6">
                        <p class="text-3xl font-bold text-green-600">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="mt-2 text-gray-600">Stok:
                            <span class="{{ $product->stock > 0 ? 'text-green-600' : 'text-red-500' }}">
                                {{ $product->stock > 0 ? $product->stock . ' tersedia' : 'Habis' }}
                            </span>
                        </p>
                    </div>
                    <div class="mt-6">
                        <p class="text-gray-900">Kategori:
                            <span class="text-green-600">
                                {{ $product->category->name ?? 'Tanpa Kategori' }}
                            </span>
                        </p>
                        <p class="mt-2 text-gray-700">{{ $product->description }}</p>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8">
                        <form action="{{ route('keranjang.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $product->id }}">

                            <div class="flex items-center mb-4">
                                <label class="mr-3 text-gray-900">Jumlah:</label>
                                <input type="number" name="jumlah" value="1" min="1"
                                    max="{{ $product->stock }}"
                                    class="w-20 bg-white border border-gray-300 rounded-lg px-3 py-2 text-gray-900">
                            </div>

                            <div class="flex flex-wrap gap-4">
                                <button type="submit"
                                    class="flex-1 bg-green-500 text-white py-3 px-6 rounded-lg font-medium hover:bg-green-600 transition btn-scale">
                                    <i class="fas fa-shopping-cart mr-2"></i>Masukkan Keranjang
                                </button>

                                <a href="{{ route('checkout.index') }}"
                                    class="flex-1 bg-gray-800 border border-gray-300 text-white py-3 px-6 rounded-lg font-medium hover:bg-gray-900 transition btn-scale">
                                    <i class="fas fa-bolt mr-2"></i>Beli Sekarang
                                </a>

                                @auth
                                    <button type="button" onclick="toggleFavorite({{ $product->id }})" id="favorite-btn"
                                        class="p-3 border border-gray-300 rounded-lg text-gray-700 hover:text-red-500 transition btn-scale favorite-btn"
                                        data-id="{{ $product->id }}" data-favorited="false">
                                        <i class="fas fa-heart"></i>
                                    </button>
                                @endauth
                            </div>
                        </form>
                    </div>  

                    <!-- Seller Info -->
                    <div class="mt-8 pt-6 border-t border-gray-300">
                        <p class="text-gray-600">Dijual oleh: <span
                                class="text-green-600">{{ $product->penjual->name ?? 'MOVR' }}</span></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Produk Serupa -->
    <section class="py-12 bg-gray-50 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-8">Produk Serupa</h2>

            @if ($relatedProducts->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($relatedProducts as $item)
                        <div
                            class="group bg-white rounded-xl border border-gray-300 overflow-hidden hover:border-green-500 transition-all duration-300 lift-effect flex flex-col h-full">

                            <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-100">
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                        class="w-full h-64 object-cover object-center group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-64 flex items-center justify-center bg-gray-200">
                                        <i class="fas fa-image text-gray-400 text-4xl opacity-50"></i>
                                    </div>
                                @endif

                                @if ($item->category)
                                    <div class="absolute top-2 left-2">
                                        <span
                                            class="px-3 py-1 text-xs font-semibold rounded-full bg-gray-800/80 text-white backdrop-blur-md border border-gray-700/20">
                                            {{ $item->category->name }}
                                        </span>
                                    </div>
                                @endif

                                <div
                                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300">
                                </div>
                            </div>

                            <div class="p-5 flex flex-col flex-grow">
                                <h3 class="text-lg font-bold text-gray-900 mb-1 truncate line-clamp-1"
                                    title="{{ $item->name }}">
                                    <a href="{{ route('produk.show', $item->id) }}"
                                        class="hover:text-green-600 transition">
                                        {{ $item->name }}
                                    </a>
                                </h3>

                                <div class="flex items-center justify-between mb-4 mt-auto">
                                    <p class="text-xl font-extrabold text-green-600">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                                        {{ round($item->ulasan->avg('rating'), 1) ?? '0.0' }}
                                    </div>
                                </div>

                                <div class="mt-4 flex items-center gap-2">
                                    <a href="{{ route('checkout.index') }}"
                                        class="flex-grow bg-green-500 text-white py-2 rounded-lg font-bold hover:bg-green-600 transition shadow-lg shadow-green-500/20 text-sm text-center">
                                        Beli
                                    </a>

                                    <form action="{{ route('keranjang.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                        <input type="hidden" name="jumlah" value="1">
                                        <button type="submit"
                                            class="bg-gray-800 border border-gray-300 text-white p-2 rounded-lg hover:border-green-500 hover:text-green-500 transition h-full flex items-center justify-center w-10"
                                            title="Masuk Keranjang">
                                            <i class="fas fa-shopping-cart"></i>
                                        </button>
                                    </form>

                                    <a href="{{ route('produk.show', $item->id) }}"
                                        class="bg-gray-800 border border-gray-300 text-white p-2 rounded-lg hover:border-blue-500 hover:text-blue-500 transition h-full flex items-center justify-center w-10"
                                        title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10">
                    <p class="text-gray-500">Belum ada produk lain di kategori ini.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Reviews Section -->
    <section class="py-8 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Ulasan Produk</h2>

            @auth
                <div class="bg-white border border-gray-300 rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Tulis Ulasan Anda</h3>
                    <form action="{{ route('ulasan.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $product->id }}">

                        <div class="mb-4">
                            <label class="block text-gray-900 mb-2">Rating</label>
                            <div class="flex">
                                <input type="radio" id="star5" name="rating" value="5" class="hidden" required>
                                <label for="star5" class="rating-star cursor-pointer text-2xl px-1 text-gray-400 hover:text-yellow-400">★</label>
                                <input type="radio" id="star4" name="rating" value="4" class="hidden">
                                <label for="star4" class="rating-star cursor-pointer text-2xl px-1 text-gray-400 hover:text-yellow-400">★</label>
                                <input type="radio" id="star3" name="rating" value="3" class="hidden">
                                <label for="star3" class="rating-star cursor-pointer text-2xl px-1 text-gray-400 hover:text-yellow-400">★</label>
                                <input type="radio" id="star2" name="rating" value="2" class="hidden">
                                <label for="star2" class="rating-star cursor-pointer text-2xl px-1 text-gray-400 hover:text-yellow-400">★</label>
                                <input type="radio" id="star1" name="rating" value="1" class="hidden">
                                <label for="star1" class="rating-star cursor-pointer text-2xl px-1 text-gray-400 hover:text-yellow-400">★</label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="komentar" class="block text-gray-900 mb-2">Komentar</label>
                            <textarea name="komentar" id="komentar" rows="4"
                                class="w-full bg-white border border-gray-300 rounded-lg px-4 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="Tulis ulasan Anda..."></textarea>
                        </div>

                        <button type="submit"
                            class="bg-green-500 text-white px-6 py-2 rounded-lg font-medium hover:bg-green-600 transition">Kirim
                            Ulasan</button>
                    </form>
                </div>
            @endauth

            <div class="space-y-6">
                @forelse($ulasan as $review)
                    <div class="bg-white border border-gray-300 rounded-lg p-6">
                        <div class="flex items-start">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <h4 class="font-medium text-gray-900">{{ $review->pembeli->name ?? 'Pembeli' }}</h4>
                                    <div class="flex">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <i class="fas fa-star text-yellow-400"></i>
                                            @else
                                                <i class="fas fa-star text-gray-400"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-gray-500 text-sm mt-1">{{ $review->created_at->format('d M Y') }}</p>
                                <p class="mt-3 text-gray-700">{{ $review->komentar ?? 'Tidak ada komentar' }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8">
                        <i class="fas fa-comment-slash text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600">Belum ada ulasan untuk produk ini.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination for reviews -->
            <div class="mt-8">
                {{ $ulasan->links() }}
            </div>
        </div>
    </section>
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
                    const btn = document.getElementById('favorite-btn');
                    const icon = btn.querySelector('i');

                    if (data.status === 'added') {
                        icon.style.color = '#ef4444 !important';
                        icon.style.fontWeight = '900 !important';
                        btn.classList.add('favorited');
                        showNotification('✓ Produk ditambahkan ke favorit', 'success');
                    } else if (data.status === 'removed') {
                        icon.style.color = 'currentColor !important';
                        icon.style.fontWeight = '400 !important';
                        btn.classList.remove('favorited');
                        showNotification('✓ Produk dihapus dari favorit', 'info');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showNotification('✗ Terjadi kesalahan', 'error');
                });
        }

        function showNotification(message, type = 'info') {
            const bgColor = {
                'success': 'bg-green-500',
                'info': 'bg-blue-500',
                'error': 'bg-red-500'
            } [type] || 'bg-blue-500';

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
            const favoriteBtn = document.getElementById('favorite-btn');
            if (!favoriteBtn) return;

            const productId = favoriteBtn.getAttribute('data-id');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

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
                        const icon = favoriteBtn.querySelector('i');
                        icon.style.color = '#ef4444 !important';
                        icon.style.fontWeight = '900 !important';
                        favoriteBtn.classList.add('favorited');
                    }
                })
                .catch(error => console.error('Error:', error));

            // Star rating functionality
            const stars = document.querySelectorAll('.rating-star');
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const value = this.getAttribute('for').replace('star', '');
                    // Update all stars up to the clicked one
                    stars.forEach((s, index) => {
                        if (index < value) {
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

        #favorite-btn.favorited i {
            color: #ef4444 !important;
            font-weight: 900 !important;
        }
    </style>
@endsection
