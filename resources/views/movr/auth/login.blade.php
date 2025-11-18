@extends('movr.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-accent-green">
                <i class="fas fa-user text-dark-bg text-xl"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-light-text">Masuk ke akun Anda</h2>
        </div>
        
        <div class="bg-card-bg border border-border-color rounded-lg p-8 shadow-xl">
            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf
                
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
                        <input id="password" name="password" type="password" required autocomplete="current-password" class="bg-dark-bg border border-border-color rounded-lg block w-full px-4 py-3 text-light-text placeholder-gray-500 focus:outline-none focus:ring-accent-green focus:border-accent-green">
                        @error('password')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-accent-green focus:ring-accent-green border-border-color rounded bg-dark-bg">
                        <label for="remember_me" class="ml-2 block text-sm text-light-text">Ingat saya</label>
                    </div>
                    
                    <div class="text-sm">
                        <a href="#" class="font-medium text-accent-green hover:text-accent-green">Lupa kata sandi?</a>
                    </div>
                </div>
                
                <div>
                    <button type="submit" class="w-full bg-accent-green text-dark-bg py-3 px-4 rounded-lg shadow-sm text-sm font-medium hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-green transition btn-scale">
                        Masuk
                    </button>
                </div>
            </form>
            
            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-border-color"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-card-bg text-gray-500">atau</span>
                    </div>
                </div>
                
                <div class="mt-6">
                    <a href="{{ route('register') }}" class="w-full flex justify-center py-2 px-4 border border-border-color rounded-lg shadow-sm text-sm font-medium text-light-text bg-dark-bg hover:bg-card-bg transition">
                        Buat akun baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection