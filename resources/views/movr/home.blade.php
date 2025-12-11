@extends('movr.layouts.app')

@section('content')
<section
    class="relative h-[600px] bg-cover bg-center"
    style="background-image: url('https://i.pinimg.com/1200x/a8/95/43/a8954340e5e4c8f99f4f984405449363.jpg');"
>
    <div class="absolute inset-0 bg-white/50 bg-gradient-to-r from-white to-transparent"></div>

    <div class="relative max-w-7xl mx-auto h-full flex items-center px-4 sm:px-6 lg:px-8">
        <div class="md:w-1/2 p-6 rounded-2xl backdrop-blur-sm bg-white/30 border border-gray-200">
            <h1 class="text-4xl md:text-5xl font-bold text-black mb-4 leading-tight">
                Tingkatkan Performa <span class="text-accent-green">Mu</span>
            </h1>
            <p class="text-lg text-gray-600 mb-8">
                Temukan koleksi terbaru produk sporty premium untuk gaya hidup aktif Anda.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('produk.index') }}" class="bg-accent-green text-white px-8 py-3 rounded-full font-bold hover:bg-accent-green/90 transition transform hover:-translate-y-1 shadow-lg shadow-accent-green/20">
                    Belanja Sekarang
                </a>
                <a href="#featured-products" class="border-2 border-accent-green text-accent-green px-8 py-3 rounded-full font-bold hover:bg-accent-green hover:text-white transition">
                    Lihat Produk
                </a>
            </div>
        </div>
    </div>
</section>

<section id="featured-products" class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-black mb-4">Produk Kami</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Pilihan produk terbaik untuk menunjang aktivitas olahraga Anda.</p>
        </div>

        @if(isset($products) && $products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $item)
                    <div class="group bg-white rounded-xl border border-gray-300 overflow-hidden hover:border-accent-green transition-all duration-300 lift-effect">

                        <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-100">
                            @if($item->image)
                                <img src="{{ asset('storage/' . $item->image) }}"
                                     alt="{{ $item->name }}"
                                     class="w-full h-64 object-cover object-center group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-64 flex items-center justify-center text-gray-500">
                                    <i class="fas fa-image text-4xl opacity-50"></i>
                                </div>
                            @endif

                            @if($item->category)
                             <div class="absolute top-2 left-2">
                                 <span class="px-3 py-1 text-xs font-semibold rounded-full bg-white/80 text-accent-green backdrop-blur-md border border-accent-green/20">
                                     {{ $item->category->name }}
                                 </span>
                             </div>
                            @endif
                        </div>

                        <div class="p-5">
                            <h3 class="text-lg font-bold text-black mb-1 truncateable">
                                <a href="{{ route('produk.show', $item->id) }}" class="hover:text-accent-green transition">
                                    {{ $item->name }}
                                </a>
                            </h3>

                            <div class="flex items-center justify-between mb-4">
                                <p class="text-xl font-extrabold text-accent-green">
                                    Rp {{ number_format($item->price, 0, ',', '.') }}
                                </p>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i> 4.9
                                </div>
                            </div>

                            <div class="mt-4 flex items-center gap-2">

                                <form action="{{ route('checkout.buyNow') }}" method="POST" class="flex-grow">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                                    <button type="submit" class="w-full bg-accent-green text-white py-2 rounded-lg font-bold hover:bg-accent-green/90 transition shadow-lg shadow-accent-green/20 text-sm">
                                        Beli
                                    </button>
                                </form>

                                <form action="{{ route('keranjang.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="produk_id" value="{{ $item->id }}">
                                    <input type="hidden" name="jumlah" value="1">
                                    <button type="submit" class="bg-white border border-gray-300 text-black p-2 rounded-lg hover:border-accent-green hover:text-accent-green transition h-full flex items-center justify-center" title="Masuk Keranjang">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                </form>

                                <a href="{{ route('produk.show', $item->id) }}"
                                   class="bg-white border border-gray-300 text-black p-2 rounded-lg hover:border-blue-500 hover:text-blue-500 transition h-full flex items-center justify-center" title="Lihat Detail">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <button onclick="toggleFavorite({{ $item->id }})"
                                        id="fav-btn-{{ $item->id }}"
                                        class="bg-white border border-gray-300 text-gray-700 p-2 rounded-lg hover:border-red-500 hover:text-red-500 transition h-full flex items-center justify-center group"
                                        title="Simpan ke Favorit">
                                    <i class="far fa-heart transition-all duration-300 transform group-active:scale-125" id="fav-icon-{{ $item->id }}"></i>
                                </button>

                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-xl border border-gray-300">
                <i class="fas fa-box-open text-6xl text-gray-400 mb-6"></i>
                <h3 class="text-2xl font-bold text-black mb-2">Belum ada produk</h3>
                <p class="text-gray-600 max-w-md mx-auto">Kami sedang menyiapkan koleksi terbaik untuk Anda. Silakan kembali lagi nanti.</p>
            </div>
        @endif
    </div>
</section>

<section class="py-20 relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-r from-accent-green to-blue-500 opacity-90"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl md:text-4xl font-bold text-white mb-6">Siap untuk Tampil Beda?</h2>
        <p class="text-xl text-white/80 mb-8 max-w-2xl mx-auto font-medium">
            Jelajahi koleksi lengkap kami dan temukan perlengkapan yang pas untuk gaya Anda.
        </p>
        <a href="{{ route('produk.index') }}" class="inline-block bg-white text-accent-green px-10 py-4 rounded-full font-bold text-lg hover:scale-105 transition-transform shadow-xl">
            Mulai Belanja Sekarang
        </a>
    </div>
</section>

<script>
    // Fungsi Utama: Mengirim request ke server
    function toggleFavorite(productId) {
        // Kirim request POST ke route favorit.toggle
        fetch('{{ route('favorit.toggle') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Token keamanan wajib Laravel
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(response => response.json())
        .then(data => {
            // Jika user belum login (status 401 dari controller)
            if (data.status === 401) {
                alert('Silakan login terlebih dahulu!');
                window.location.href = '{{ route('login') }}';
                return;
            }
            // Update tampilan ikon berdasarkan respons server
            if (data) {
                updateFavoriteIcon(productId, data.isFavorited);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Fungsi Update Tampilan Ikon
    function updateFavoriteIcon(productId, isFavorited) {
        const btn = document.getElementById(`fav-btn-${productId}`);
        const icon = document.getElementById(`fav-icon-${productId}`);

        if (isFavorited) {
            // Jika Favorit: Ikon Solid (fas), Warna Merah
            icon.classList.remove('far'); // Hapus outline
            icon.classList.add('fas');    // Tambah solid
            btn.classList.add('text-red-500', 'border-red-500'); // Ubah warna tombol jadi merah
            btn.classList.remove('text-gray-700', 'border-gray-300');
        } else {
            // Jika Tidak Favorit: Ikon Outline (far), Warna Normal
            icon.classList.remove('fas'); // Hapus solid
            icon.classList.add('far');    // Tambah outline
            btn.classList.remove('text-red-500', 'border-red-500'); // Hapus warna merah
            btn.classList.add('text-gray-700', 'border-gray-300');
        }
    }

    // Cek Status Favorit saat Halaman Dimuat
    // Agar saat di-refresh, produk yang sudah dilike tetap merah
    document.addEventListener('DOMContentLoaded', function() {
        @auth
            // Ambil semua ID produk yang ada di halaman ini
            const productIds = @json($products->pluck('id'));

            // Loop setiap produk untuk cek status favoritnya
            productIds.forEach(id => {
                fetch('{{ route('favorit.toggle') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ product_id: id, check_only: true })
                })
                .then(res => res.json())
                .then(data => {
                    if(data.isFavorited) {
                        updateFavoriteIcon(id, true);
                    }
                });
            });
        @endauth
    });
</script>
@endsection