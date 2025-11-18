@extends('movr.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-accent-green">
                <i class="fas fa-user-plus text-dark-bg text-xl"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-light-text">Buat akun baru</h2>
        </div>
        
        <div class="bg-card-bg border border-border-color rounded-lg p-8 shadow-xl">
            <form class="space-y-6" method="POST" action="{{ route('register') }}">
                @csrf
                
                <div>
                    <label for="name" class="block text-sm font-medium text-light-text">Nama Lengkap</label>
                    <div class="mt-1">
                        <input id="name" name="name" type="text" required autocomplete="name" value="{{ old('name') }}" class="bg-dark-bg border border-border-color rounded-lg block w-full px-4 py-3 text-light-text placeholder-gray-500 focus:outline-none focus:ring-accent-green focus:border-accent-green">
                        @error('name')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-light-text">Alamat Email</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required autocomplete="email" value="{{ old('email') }}" class="bg-dark-bg border border-border-color rounded-lg block w-full px-4 py-3 text-light-text placeholder-gray-500 focus:outline-none focus:ring-accent-green focus:border-accent-green">
                        @error('email')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-light-text">Kata Sandi</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required autocomplete="new-password" class="bg-dark-bg border border-border-color rounded-lg block w-full px-4 py-3 text-light-text placeholder-gray-500 focus:outline-none focus:ring-accent-green focus:border-accent-green">
                        @error('password')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-light-text">Konfirmasi Kata Sandi</label>
                    <div class="mt-1">
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="bg-dark-bg border border-border-color rounded-lg block w-full px-4 py-3 text-light-text placeholder-gray-500 focus:outline-none focus:ring-accent-green focus:border-accent-green">
                    </div>
                </div>
                
                <div>
                    <button type="submit" class="w-full bg-accent-green text-dark-bg py-3 px-4 rounded-lg shadow-sm text-sm font-medium hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-green transition btn-scale">
                        Daftar
                    </button>
                </div>
            </form>
            
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-border-color"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-card-bg text-gray-500">sudah punya akun?</span>
                    </div>
                </div>
                
                <div class="mt-6">
                    <a href="{{ route('login') }}" class="w-full flex justify-center py-2 px-4 border border-border-color rounded-lg shadow-sm text-sm font-medium text-light-text bg-dark-bg hover:bg-card-bg transition">
                        Masuk ke akun
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection