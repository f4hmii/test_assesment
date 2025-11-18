@extends('movr.layouts.app')

@section('content')
<!-- Admin Products Edit Header -->
<section class="py-6 bg-darker-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-light-text">Edit Produk</h1>
                <p class="text-gray-400">Edit informasi produk "{{ $produk->nama_produk }}"</p>
            </div>
            <a href="{{ route('admin.produk.index') }}" class="text-accent-green hover:underline">
                <i class="fas fa-arrow-left mr-2"></i>Kembali ke Daftar
            </a>
        </div>
    </div>
</section>

<!-- Admin Products Edit Content -->
<section class="py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-card-bg border border-border-color rounded-lg p-6">
            <form method="POST" action="{{ route('admin.produk.update', $produk->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="space-y-6">
                    <div>
                        <label for="nama_produk" class="block text-sm font-medium text-light-text mb-1">Nama Produk</label>
                        <input type="text" id="nama_produk" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                        @error('nama_produk')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="deskripsi" class="block text-sm font-medium text-light-text mb-1">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4" required class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="harga" class="block text-sm font-medium text-light-text mb-1">Harga (Rp)</label>
                            <input type="number" id="harga" name="harga" value="{{ old('harga', $produk->harga) }}" required min="0" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                            @error('harga')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="stok" class="block text-sm font-medium text-light-text mb-1">Stok</label>
                            <input type="number" id="stok" name="stok" value="{{ old('stok', $produk->stok) }}" required min="0" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                            @error('stok')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="kategori" class="block text-sm font-medium text-light-text mb-1">Kategori</label>
                            <select id="kategori" name="kategori" required class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                <option value="">Pilih Kategori</option>
                                <option value="Sepatu" {{ old('kategori', $produk->kategori) == 'Sepatu' ? 'selected' : '' }}>Sepatu</option>
                                <option value="Pakaian" {{ old('kategori', $produk->kategori) == 'Pakaian' ? 'selected' : '' }}>Pakaian</option>
                                <option value="Aksesoris" {{ old('kategori', $produk->kategori) == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                                <option value="Perlengkapan" {{ old('kategori', $produk->kategori) == 'Perlengkapan' ? 'selected' : '' }}>Perlengkapan</option>
                            </select>
                            @error('kategori')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="gambar" class="block text-sm font-medium text-light-text mb-1">Gambar Produk</label>
                            <input type="file" id="gambar" name="gambar" accept="image/*" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                            <p class="mt-1 text-sm text-gray-400">Ukuran maksimal 2MB, format: jpeg, png, jpg</p>
                            @error('gambar')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                            
                            @if($produk->gambar)
                                <div class="mt-4">
                                    <p class="text-sm text-gray-400 mb-2">Gambar saat ini:</p>
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama_produk }}" class="w-32 h-32 object-cover rounded-lg border border-border-color">
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('admin.produk.index') }}" class="bg-dark-bg border border-border-color text-light-text py-3 px-6 rounded-lg font-medium hover:bg-card-bg transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-accent-green text-dark-bg py-3 px-6 rounded-lg font-medium hover:bg-opacity-90 transition">
                            <i class="fas fa-save mr-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection