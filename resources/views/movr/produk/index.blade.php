@extends('movr.layouts.app')

@section('content')
<section class="py-12 bg-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-black">Semua Produk</h1>
        <p class="mt-2 text-gray-600">Temukan produk sporty terbaik untuk gaya hidup aktif Anda</p>
    </div>
</section>

<section class="py-12 bg-white min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row gap-8">

            <div class="md:w-1/4">
                <div class="bg-white border border-gray-300 rounded-lg p-6 sticky top-6">
                    <h3 class="text-lg font-bold text-black mb-4 border-b border-gray-300 pb-2">Filter</h3>

                    <div class="mb-6">
                        <h4 class="font-medium text-black mb-3">Kategori</h4>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('produk.index') }}" class="text-gray-600 hover:text-accent-green transition {{ !request('kategori') ? 'text-accent-green font-bold' : '' }}">
                                    Semua Kategori
                                </a>
                            </li>
                            @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('produk.index', ['kategori' => $cat->slug]) }}" class="text-gray-600 hover:text-accent-green transition {{ request('kategori') == $cat->slug ? 'text-accent-green font-bold' : '' }}">
                                    {{ $cat->name }}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <div class="md:w-3/4">
                <div class="flex justify-between items-center mb-6">
                    <p class="text-gray-600">{{ $products->total() }} produk ditemukan</p>
                </div>

                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $item)
                            <div class="group bg-white rounded-xl border border-gray-300 overflow-hidden hover:border-accent-green transition-all duration-300 lift-effect">

                                <div class="relative aspect-w-1 aspect-h-1 w-full overflow-hidden bg-gray-100">
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-64 object-cover object-center group-hover:scale-110 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-64 flex items-center justify-center bg-gray-200">
                                            <i class="fas fa-image text-gray-500 text-4xl opacity-50"></i>
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
                                        {{ $item->name }}
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

                                        <a href="{{ route('produk.show', $item->id) }}" class="bg-white border border-gray-300 text-black p-2 rounded-lg hover:border-blue-500 hover:text-blue-500 transition h-full flex items-center justify-center" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-12">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-16 bg-white rounded-xl border border-gray-300">
                        <i class="fas fa-box-open text-6xl text-gray-400 mb-6"></i>
                        <h3 class="text-xl font-medium text-black mb-2">Tidak ada produk ditemukan</h3>
                        <p class="text-gray-600">Belum ada produk atau coba ganti filter kategori.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection