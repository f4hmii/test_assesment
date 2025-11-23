@extends('movr.layouts.app')

@section('content')
<section class="py-6 bg-darker-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-light-text">Kelola Produk</h1>
                <p class="text-gray-400">Tambah, edit, atau hapus produk Anda</p>
            </div>
            <a href="{{ route('admin.produk.create') }}" class="bg-accent-green text-dark-bg py-2 px-4 rounded-lg font-medium hover:bg-opacity-90 transition">
                <i class="fas fa-plus mr-2"></i>Tambah Produk
            </a>
        </div>
    </div>
</section>

@if(session('success'))
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded relative">
        {{ session('success') }}
    </div>
</div>
@endif

<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-card-bg border border-border-color rounded-lg overflow-hidden">
            
            <div class="p-6 border-b border-border-color">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold text-light-text">Daftar Produk</h2>
                    <div class="flex space-x-4">
                        <input type="text" placeholder="Cari produk..." class="bg-dark-bg border border-border-color rounded-lg px-4 py-2 text-light-text focus:outline-none focus:border-accent-green">
                    </div>
                </div>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-border-color">
                    <thead class="bg-dark-bg">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Produk</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Harga</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Stok</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Kategori</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-color">
                        {{-- PERBAIKAN: Menggunakan variable $products (bukan $produk) --}}
                        @forelse($products as $item)
                        <tr class="hover:bg-dark-bg/50 transition">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-card-bg rounded-md overflow-hidden border border-border-color">
                                        {{-- PERBAIKAN: Menggunakan $item->image --}}
                                        @if($item->image)
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="fas fa-image text-gray-500 text-sm"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        {{-- PERBAIKAN: Menggunakan $item->name --}}
                                        <div class="text-sm font-medium text-light-text">{{ $item->name }}</div>
                                        <div class="text-sm text-gray-400">Admin</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-accent-green font-medium">
                                {{-- PERBAIKAN: Menggunakan $item->price --}}
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                                {{-- PERBAIKAN: Menggunakan $item->stock --}}
                                {{ $item->stock }}
                            </td>
                            
                            {{-- Menampilkan Kategori --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-light-text">
                                @if($item->category)
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-900/30 text-blue-200">
                                        {{ $item->category->name }}
                                    </span>
                                @else
                                    <span class="text-gray-500 italic">Tanpa Kategori</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $item->stock > 0 ? 'bg-green-900/30 text-green-400' : 'bg-red-900/30 text-red-400' }}">
                                    {{ $item->stock > 0 ? 'Tersedia' : 'Habis' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-3">
                                    <a href="{{ route('admin.produk.edit', $item->id) }}" class="text-blue-500 hover:text-blue-400 transition" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.produk.destroy', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400 transition" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">
                                <div class="flex flex-col items-center justify-center">
                                    <i class="fas fa-box-open text-4xl mb-3 opacity-50"></i>
                                    <p class="mb-2">Belum ada produk tersedia.</p>
                                    <a href="{{ route('admin.produk.create') }}" class="text-accent-green hover:underline">Tambah Produk Sekarang</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 bg-dark-bg border-t border-border-color">
                <div class="text-sm text-gray-400">
                    Menampilkan total <span class="font-bold text-light-text">{{ $products->count() }}</span> produk.
                </div>
            </div>
        </div>
    </div>
</section>
@endsection