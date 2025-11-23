@extends('movr.layouts.app')

@section('content')
<section class="py-8">
    <div class="max-w-2xl mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-light-text">Tambah Kategori</h1>
            <a href="{{ route('admin.kategori.index') }}" class="text-accent-green hover:underline">&larr; Kembali</a>
        </div>

        <div class="bg-card-bg border border-border-color rounded-lg p-6">
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <label class="block text-gray-400 text-sm font-bold mb-2">Nama Kategori</label>
                    <input type="text" name="name" class="w-full bg-dark-bg border border-border-color rounded py-3 px-4 text-light-text focus:outline-none focus:border-accent-green" placeholder="Misal: Sepatu Lari" required>
                </div>
                <button type="submit" class="bg-accent-green text-dark-bg font-bold py-3 px-6 rounded w-full hover:opacity-90">
                    Simpan Kategori
                </button>
            </form>
        </div>
    </div>
</section>
@endsection