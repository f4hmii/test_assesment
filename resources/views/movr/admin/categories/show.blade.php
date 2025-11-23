@extends('movr.layouts.app')

@section('content')
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between items-center mb-6">
            <div>
                <a href="{{ route('admin.kategori.index') }}" class="text-gray-400 hover:text-white text-sm mb-2 block">&larr; Kembali ke Daftar</a>
                <h1 class="text-2xl font-bold text-light-text">
                    Kategori: <span class="text-accent-green">{{ $kategori->name }}</span>
                </h1>
            </div>
            <a href="{{ route('admin.produk.create') }}" class="bg-dark-bg border border-border-color text-light-text py-2 px-4 rounded hover:bg-card-bg transition">
                + Tambah Produk Baru
            </a>
        </div>

        <div class="bg-card-bg border border-border-color rounded-lg overflow-hidden">
            <div class="p-4 border-b border-border-color">
                <h3 class="text-lg font-bold text-light-text">Daftar Produk dalam Kategori Ini</h3>
            </div>
            
            <table class="min-w-full divide-y divide-border-color">
                <thead class="bg-dark-bg">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Stok</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-color">
                    @forelse($products as $produk)
                    <tr class="hover:bg-dark-bg/50 transition">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                @if($produk->image)
                                    <img src="{{ asset('storage/' . $produk->image) }}" class="h-10 w-10 rounded object-cover mr-3">
                                @else
                                    <div class="h-10 w-10 bg-dark-bg rounded mr-3 flex items-center justify-center text-xs text-gray-500">No img</div>
                                @endif
                                <span class="text-light-text font-medium">{{ $produk->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-accent-green">Rp {{ number_format($produk->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-400">{{ $produk->stock }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.produk.edit', $produk->id) }}" class="text-blue-400 hover:text-blue-300 mr-3">Edit</a>
                            
                            <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" class="inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400" onclick="return confirm('Hapus produk ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            Belum ada produk di kategori ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection