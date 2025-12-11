@extends('movr.layouts.app')

@section('content')
<section class="py-6 bg-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-black">Keranjang Belanja</h1>
    </div>
</section>

<section class="py-8 min-h-screen bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Pesan Status --}}
        @if(session('status'))
            <div class="bg-green-100 border border-green-500 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('status') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-500 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($keranjangItems->count() > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="lg:w-2/3">
                    <div class="bg-white border border-gray-300 rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Qty</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-300">
                                @foreach($keranjangItems as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-16 w-16 bg-gray-200 rounded-md overflow-hidden border border-gray-300">
                                                @if($item->produk->image)
                                                    <img src="{{ asset('storage/' . $item->produk->image) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center"><i class="fas fa-image text-gray-500"></i></div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-black">{{ $item->produk->name }}</div>
                                                <div class="text-xs text-gray-600">
                                                    {{ $item->produk->category ? $item->produk->category->name : 'Umum' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-accent-green">
                                        Rp {{ number_format($item->harga_saat_ini, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <form action="{{ route('keranjang.update', $item->id) }}" method="POST" class="flex items-center">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" max="{{ $item->produk->stock }}" class="w-16 bg-white border border-gray-300 rounded px-2 py-1 text-black text-center focus:outline-none focus:border-accent-green">
                                            <button type="submit" class="ml-2 text-accent-green hover:text-black transition" title="Update">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black font-bold">
                                        Rp {{ number_format($item->jumlah * $item->harga_saat_ini, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <form action="{{ route('keranjang.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 transition" onclick="return confirm('Hapus produk ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="text-gray-600 hover:text-accent-green text-sm flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i> Lanjutkan Belanja
                        </a>
                    </div>
                </div>

                <div class="lg:w-1/3">
                    <div class="bg-white border border-gray-300 rounded-lg p-6 sticky top-6">
                        <h2 class="text-lg font-bold text-black mb-4">Ringkasan Pesanan</h2>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-600 text-sm">
                                <span>Total Item</span>
                                <span>{{ $keranjangItems->sum('jumlah') }} pcs</span>
                            </div>
                            <div class="border-t border-dashed border-gray-300 pt-3 mt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-black">Total</span>
                                    <span class="text-xl font-bold text-accent-green">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <button onclick="alert('Fitur Checkout Massal dari Keranjang akan segera hadir! Silakan gunakan tombol Beli Langsung di halaman produk untuk saat ini.')" class="w-full bg-accent-green text-white py-3 px-4 rounded-lg text-center font-bold hover:bg-accent-green/90 transition shadow-lg shadow-accent-green/20">
                            Checkout Sekarang
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-20 bg-white rounded-lg border border-gray-300">
                <i class="fas fa-shopping-cart text-6xl text-gray-400 mb-6"></i>
                <h3 class="text-xl font-bold text-black mb-2">Keranjang Anda kosong</h3>
                <p class="text-gray-600 mb-8">Belum ada produk yang ditambahkan.</p>
                <a href="{{ route('home') }}" class="inline-block bg-accent-green text-white py-3 px-8 rounded-full font-bold hover:bg-accent-green/90 transition">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</section>
@endsection