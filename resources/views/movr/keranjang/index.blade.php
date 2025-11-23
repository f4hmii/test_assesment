@extends('movr.layouts.app')

@section('content')
<section class="py-6 bg-darker-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-light-text">Keranjang Belanja</h1>
    </div>
</section>

<section class="py-8 min-h-screen bg-dark-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Pesan Status --}}
        @if(session('status'))
            <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded mb-6">
                {{ session('status') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        @if($keranjangItems->count() > 0)
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="lg:w-2/3">
                    <div class="bg-card-bg border border-border-color rounded-lg overflow-hidden">
                        <table class="min-w-full divide-y divide-border-color">
                            <thead class="bg-dark-bg">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Qty</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-border-color">
                                @foreach($keranjangItems as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-16 w-16 bg-dark-bg rounded-md overflow-hidden border border-border-color">
                                                @if($item->produk->image)
                                                    <img src="{{ asset('storage/' . $item->produk->image) }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center"><i class="fas fa-image text-gray-500"></i></div>
                                                @endif
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-bold text-light-text">{{ $item->produk->name }}</div>
                                                <div class="text-xs text-gray-400">
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
                                            <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" max="{{ $item->produk->stock }}" class="w-16 bg-dark-bg border border-border-color rounded px-2 py-1 text-light-text text-center focus:outline-none focus:border-accent-green">
                                            <button type="submit" class="ml-2 text-accent-green hover:text-white transition" title="Update">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-light-text font-bold">
                                        Rp {{ number_format($item->jumlah * $item->harga_saat_ini, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <form action="{{ route('keranjang.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-400 transition" onclick="return confirm('Hapus produk ini?')">
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
                        <a href="{{ route('home') }}" class="text-gray-400 hover:text-accent-green text-sm flex items-center">
                            <i class="fas fa-arrow-left mr-2"></i> Lanjutkan Belanja
                        </a>
                    </div>
                </div>
                
                <div class="lg:w-1/3">
                    <div class="bg-card-bg border border-border-color rounded-lg p-6 sticky top-6">
                        <h2 class="text-lg font-bold text-light-text mb-4">Ringkasan Pesanan</h2>
                        
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between text-gray-400 text-sm">
                                <span>Total Item</span>
                                <span>{{ $keranjangItems->sum('jumlah') }} pcs</span>
                            </div>
                            <div class="border-t border-dashed border-border-color pt-3 mt-3">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-light-text">Total</span>
                                    <span class="text-xl font-bold text-accent-green">Rp {{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>

                        <button onclick="alert('Fitur Checkout Massal dari Keranjang akan segera hadir! Silakan gunakan tombol Beli Langsung di halaman produk untuk saat ini.')" class="w-full bg-accent-green text-dark-bg py-3 px-4 rounded-lg text-center font-bold hover:bg-opacity-90 transition shadow-lg shadow-accent-green/20">
                            Checkout Sekarang
                        </button>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-20 bg-card-bg rounded-lg border border-border-color">
                <i class="fas fa-shopping-cart text-6xl text-gray-600 mb-6"></i>
                <h3 class="text-xl font-bold text-light-text mb-2">Keranjang Anda kosong</h3>
                <p class="text-gray-400 mb-8">Belum ada produk yang ditambahkan.</p>
                <a href="{{ route('home') }}" class="inline-block bg-accent-green text-dark-bg py-3 px-8 rounded-full font-bold hover:bg-opacity-90 transition">
                    Mulai Belanja
                </a>
            </div>
        @endif
    </div>
</section>
@endsection