@extends('movr.layouts.app')

@section('content')
<section class="py-12 bg-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-black">Produk Favorit Saya</h1>
        {{-- PERBAIKAN: Menggunakan $favorits (sesuai controller) --}}
        <p class="mt-2 text-gray-600">{{ $favorits->total() }} produk tersimpan</p>
    </div>
</section>

<section class="py-12 bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        @if($favorits->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($favorits as $item)
                    @if($item->product)
                    <div class="group bg-white rounded-xl border border-gray-300 overflow-hidden hover:border-accent-green transition-all duration-300 lift-effect relative">

                        <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-100">
                            @if($item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}"
                                     alt="{{ $item->product->name }}"
                                     class="w-full h-64 object-cover object-center group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div class="w-full h-64 flex items-center justify-center text-gray-500">
                                    <i class="fas fa-image text-4xl opacity-50"></i>
                                </div>
                            @endif
                        </div>

                        <div class="p-5">
                            <h3 class="text-lg font-bold text-black mb-1 truncateable">
                                <a href="{{ route('produk.show', $item->product->id) }}" class="hover:text-accent-green transition">
                                    {{ $item->product->name }}
                                </a>
                            </h3>

                            <p class="text-xl font-extrabold text-accent-green mb-4">
                                Rp {{ number_format($item->product->price, 0, ',', '.') }}
                            </p>

                            <div class="flex gap-2">
                                <form action="{{ route('checkout.buyNow') }}" method="POST" class="flex-grow">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                                    <button type="submit" class="w-full bg-accent-green text-white py-2 rounded-lg font-bold hover:bg-accent-green/90 transition text-sm">
                                        Beli
                                    </button>
                                </form>

                                <button onclick="removeFavorite({{ $item->product->id }})"
                                        class="bg-white border border-red-500 text-red-500 p-2 rounded-lg hover:bg-red-500 hover:text-white transition"
                                        title="Hapus dari Favorit">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            </div>

            <div class="mt-12">
                {{ $favorits->links() }}
            </div>

        @else
            <div class="text-center py-20 bg-white rounded-lg border border-gray-300">
                <i class="far fa-heart text-6xl text-gray-400 mb-6"></i>
                <h3 class="text-xl font-bold text-black mb-2">Belum ada favorit</h3>
                <p class="text-gray-600 mb-8">Simpan produk yang Anda suka untuk dilihat nanti.</p>
                <a href="{{ route('produk.index') }}" class="inline-block bg-accent-green text-white py-3 px-8 rounded-full font-bold hover:bg-accent-green/90 transition">
                    Cari Produk
                </a>
            </div>
        @endif
    </div>
</section>

<script>
    function removeFavorite(productId) {
        if(!confirm('Hapus produk ini dari favorit?')) return;

        fetch('{{ route('favorit.toggle') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'removed') {
                // Reload halaman agar item menghilang
                location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection