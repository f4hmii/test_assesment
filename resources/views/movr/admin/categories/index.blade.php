@extends('movr.layouts.app')

@section('content')
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-light-text">Daftar Kategori</h1>
            <a href="{{ route('admin.kategori.create') }}" class="bg-accent-green text-dark-bg font-bold py-2 px-4 rounded hover:opacity-90 transition">
                + Tambah Kategori
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 text-green-500 p-4 rounded mb-4 border border-green-500/50">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-card-bg border border-border-color rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-border-color">
                <thead class="bg-dark-bg">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Jumlah Produk</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border-color">
                    @forelse($categories as $category)
                    <tr class="hover:bg-dark-bg/50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-light-text font-bold">{{ $category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-400">
                            {{ $category->products_count }} Produk
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.kategori.show', $category->id) }}" class="text-blue-400 hover:text-blue-300 mr-4">
                                <i class="fas fa-eye"></i> Lihat Produk
                            </a>

                            <a href="{{ route('admin.kategori.edit', $category->id) }}" class="text-accent-green hover:underline mr-4">Edit</a>
                            
                            <form action="{{ route('admin.kategori.destroy', $category->id) }}" method="POST" class="inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-500 hover:underline" onclick="return confirm('Hapus kategori ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                            <i class="fas fa-folder-open text-4xl mb-3 block"></i>
                            Belum ada kategori yang dibuat.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection