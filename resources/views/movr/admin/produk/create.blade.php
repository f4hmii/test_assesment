@extends('movr.layouts.app')

@section('content')
<section class="py-8">
    <div class="max-w-4xl mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-light-text">Tambah Produk Baru</h1>
                <p class="text-gray-400">Tambahkan produk baru untuk dijual</p>
            </div>
            <a href="{{ route('admin.produk.index') }}" class="text-accent-green hover:underline">&larr; Kembali ke Daftar</a>
        </div>

        <div class="bg-card-bg border border-border-color rounded-lg p-8">
            <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-6">
                    <label class="block text-gray-400 text-sm font-bold mb-2">Nama Produk</label>
                    <input type="text" name="name" class="w-full bg-dark-bg border border-border-color rounded py-3 px-4 text-light-text focus:outline-none focus:border-accent-green" placeholder="Nama Produk" required>
                </div>

                <div class="mb-6">
                    <label class="block text-gray-400 text-sm font-bold mb-2">Deskripsi</label>
                    <textarea name="description" rows="4" class="w-full bg-dark-bg border border-border-color rounded py-3 px-4 text-light-text focus:outline-none focus:border-accent-green" placeholder="Deskripsi produk..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-gray-400 text-sm font-bold mb-2">Harga (Rp)</label>
                        <input type="number" name="price" class="w-full bg-dark-bg border border-border-color rounded py-3 px-4 text-light-text focus:outline-none focus:border-accent-green" placeholder="0" required>
                    </div>
                    <div>
                        <label class="block text-gray-400 text-sm font-bold mb-2">Stok</label>
                        <input type="number" name="stock" class="w-full bg-dark-bg border border-border-color rounded py-3 px-4 text-light-text focus:outline-none focus:border-accent-green" placeholder="0" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-gray-400 text-sm font-bold mb-2">Kategori</label>
                        <select name="category_id" class="w-full bg-dark-bg border border-border-color rounded py-3 px-4 text-light-text focus:outline-none focus:border-accent-green" required>
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-gray-400 text-sm font-bold mb-2">Gambar Produk</label>
                        <input type="file" name="image" class="w-full bg-dark-bg border border-border-color rounded py-2 px-4 text-gray-400 focus:outline-none focus:border-accent-green">
                        <p class="text-xs text-gray-500 mt-1">Ukuran maksimal 2MB, format: jpeg, png, jpg</p>
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit" class="bg-accent-green text-dark-bg font-bold py-3 px-8 rounded hover:opacity-90 transition">
                        <i class="fas fa-save mr-2"></i> Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection