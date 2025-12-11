@extends('movr.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <div class="mx-auto h-12 w-12 flex items-center justify-center rounded-full bg-accent-green">
                <i class="fas fa-user-plus text-white text-xl"></i>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-black">Buat akun baru</h2>
        </div>

        <div class="bg-white border border-gray-300 rounded-lg p-8 shadow-xl">
            <form class="space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-black">Nama Lengkap</label>
                    <div class="mt-1">
                        <input id="name" name="name" type="text" required autocomplete="name" value="{{ old('name') }}" class="bg-white border border-gray-300 rounded-lg block w-full px-4 py-3 text-black placeholder-gray-500 focus:outline-none focus:ring-accent-green focus:border-accent-green">
                        @error('name')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-black">Alamat Email</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required autocomplete="email" value="{{ old('email') }}" class="bg-white border border-gray-300 rounded-lg block w-full px-4 py-3 text-black placeholder-gray-500 focus:outline-none focus:ring-accent-green focus:border-accent-green">
                        @error('email')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-black">Kata Sandi</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required autocomplete="new-password" class="bg-white border border-gray-300 rounded-lg block w-full px-4 py-3 text-black placeholder-gray-500 focus:outline-none focus:ring-accent-green focus:border-accent-green">
                        @error('password')
                            <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-black">Konfirmasi Kata Sandi</label>
                    <div class="mt-1">
                        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="bg-white border border-gray-300 rounded-lg block w-full px-4 py-3 text-black placeholder-gray-500 focus:outline-none focus:ring-accent-green focus:border-accent-green">
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full bg-accent-green text-white py-3 px-4 rounded-lg shadow-sm text-sm font-medium hover:bg-accent-green/90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-green transition btn-scale">
                        Daftar
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">sudah punya akun?</span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('login') }}" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-black bg-white hover:bg-gray-100 transition">
                        Masuk ke akun
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection