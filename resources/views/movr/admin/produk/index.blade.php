@extends('movr.layouts.app')

@section('content')
<!-- Admin Products Header -->
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

<!-- Admin Products Content -->
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-card-bg border border-border-color rounded-lg overflow-hidden">
            <div class="p-6 border-b border-border-color">
                <div class="flex justify-between items-center">
                    <h2 class="text-lg font-bold text-light-text">Daftar Produk</h2>
                    <div class="flex space-x-4">
                        <input type="text" placeholder="Cari produk..." class="bg-dark-bg border border-border-color rounded-lg px-4 py-2 text-light-text">
                        <select class="bg-dark-bg border border-border-color rounded-lg px-4 py-2 text-light-text">
                            <option>Semua Kategori</option>
                            <option>Sepatu</option>
                            <option>Pakaian</option>
                            <option>Aksesoris</option>
                            <option>Perlengkapan</option>
                        </select>
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
                        @forelse($produk as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-card-bg rounded-md overflow-hidden border border-border-color">
                                        @if($item->gambar)
                                            <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_produk }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="fas fa-image text-gray-500 text-sm"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-light-text">{{ $item->nama_produk }}</div>
                                        <div class="text-sm text-gray-400">{{ $item->penjual->name ?? 'Admin' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-light-text">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="{{ $item->stok > 0 ? 'text-accent-green' : 'text-red-500' }}">
                                    {{ $item->stok }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-light-text">{{ $item->kategori }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $item->stok > 0 ? 'bg-green-900 text-green-100' : 'bg-red-900 text-red-100' }}">
                                    {{ $item->stok > 0 ? 'Tersedia' : 'Habis' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.produk.edit', $item->id) }}" class="text-blue-500 hover:text-blue-400">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.produk.destroy', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-400" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-400">
                                <i class="fas fa-box text-3xl mb-2"></i>
                                <p>Belum ada produk tersedia</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4 bg-dark-bg border-t border-border-color">
                <div class="flex justify-between items-center">
                    <div class="text-sm text-gray-400">
                        Menampilkan {{ $produk->count() }} dari {{ $produk->total() }} produk
                    </div>
                    <div>
                        {{ $produk->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection