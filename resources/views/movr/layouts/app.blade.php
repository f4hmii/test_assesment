<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MOVR - E-commerce Sporty</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-bg': '#ffffff',  // White background
                        'darker-bg': '#f5f5f5', // Light grey background
                        'light-text': '#000000',  // Black text
                        'accent-green': '#00bf8f',
                        'accent-blue': '#00a3ff',
                        'card-bg': '#ffffff',  // White card background
                        'border-color': '#d1d5db',  // Light grey border
                    }
                }
            }
        }
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-dark-bg text-light-text min-h-screen flex flex-col">

    {{-- ========================= --}}
    {{--  NAVBAR BUYER (HILANG UNTUK ADMIN) --}}
    {{-- ========================= --}}
    @if(!auth()->check() || !auth()->user()->isAdmin())
        <nav class="bg-darker-bg border-b border-border-color sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">

                    <!-- Logo -->
                    <div class="flex-shrink-0 flex items-center">
                        <a href="{{ route('home') }}" class="text-2xl font-bold text-accent-green">
                            <i class="fas fa-running mr-2"></i>MOVR
                        </a>
                    </div>

                    <!-- Search -->
                    <div class="flex-1 mx-8">
                        <div class="relative">
                            <input type="text" placeholder="Cari produk..."
                                   class="w-full bg-white border border-gray-300 rounded-full py-2 px-4 pl-10 text-gray-900 focus:outline-none focus:ring-2 focus:ring-accent-green">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-500"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Items -->
                    <div class="flex items-center space-x-6">

                        @auth
                            <!-- Cart -->
                            <a href="{{ route('keranjang.index') }}" class="text-gray-900 hover:text-accent-green transition">
                                <i class="fas fa-shopping-cart text-xl relative">
                                    @if(auth()->user()->keranjangItems()->count() > 0)
                                        <span class="absolute -top-2 -right-2 bg-accent-green text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                            {{ auth()->user()->keranjangItems()->count() }}
                                        </span>
                                    @endif
                                </i>
                            </a>

                            <!-- Favorites -->
                            <a href="{{ route('favorit.index') }}" class="text-gray-900 hover:text-accent-green transition">
                                <i class="fas fa-heart text-xl"></i>
                            </a>

                            <!-- Profile Dropdown -->
                            <div class="relative">
                                <button id="userMenuBtn" class="flex items-center space-x-2 text-gray-900 hover:text-accent-green transition">
                                    <span class="font-medium">{{ auth()->user()->name }}</span>
                                    <i class="fas fa-chevron-down text-sm"></i>
                                </button>

                                <div id="userMenu" class="absolute right-0 mt-2 w-48 bg-white border border-gray-300 rounded-md shadow-lg py-1 hidden z-50">
                                    <a href="{{ route('profil.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Profil Saya</a>
                                    <a href="{{ route('keranjang.index') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Keranjang</a>

                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">Admin Dashboard</a>
                                    @endif

                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left block px-4 py-2 text-sm hover:bg-gray-100">Logout</button>
                                    </form>
                                </div>
                            </div>

                        @else
                            <a href="{{ route('login') }}" class="text-sm font-medium hover:text-accent-green transition">Masuk</a>
                            <a href="{{ route('register') }}" class="ml-4 px-4 py-2 bg-accent-green text-white rounded-full text-sm font-medium hover:bg-accent-green/90 transition">Daftar</a>
                        @endauth

                    </div>
                </div>

                <!-- Secondary Navigation -->
                <div class="flex space-x-8">
                    <a href="{{ route('home') }}" class="py-3 text-sm font-medium hover:text-accent-green transition {{ request()->routeIs('home') ? 'nav-active' : '' }}">Beranda</a>
                    <a href="{{ route('produk.index') }}" class="py-3 text-sm font-medium hover:text-accent-green transition {{ request()->routeIs('produk.*') ? 'nav-active' : '' }}">Produk</a>

                    @auth
                        <a href="{{ route('keranjang.index') }}" class="py-3 text-sm font-medium hover:text-accent-green transition {{ request()->routeIs('keranjang.*') ? 'nav-active' : '' }}">Keranjang</a>
                        <a href="{{ route('profil.index') }}" class="py-3 text-sm font-medium hover:text-accent-green transition {{ request()->routeIs('profil.*') ? 'nav-active' : '' }}">Profil</a>
                    @endauth
                </div>
            </div>
        </nav>
    @endif
    {{-- END NAVBAR --}}
    {{-- ========================= --}}
{{-- ========================= --}}
{{--  NAVBAR ADMIN --}}
{{-- ========================= --}}
@if(auth()->check() && auth()->user()->isAdmin())
<nav class="bg-darker-bg border-b border-border-color sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-accent-blue">
                    <i class="fas fa-user-shield mr-2"></i>Admin MOVR
                </a>
            </div>

            <!-- Menu -->
            <div class="flex items-center space-x-6">
                <a href="{{ route('admin.dashboard') }}"
                   class="text-gray-900 hover:text-accent-green transition">
                    Dashboard
                </a>

                <a href="{{ route('admin.produk.index') }}"
                   class="text-gray-900 hover:text-accent-green transition">
                    Kelola Produk
                </a>
                <!-- ADMIN LOGOUT -->
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="px-4 py-2 bg-red-600 rounded-md text-white hover:bg-red-700 transition">
                        Logout
                    </button>
                </form>
            </div>

        </div>
    </div>
</nav>
@endif
{{-- END NAVBAR ADMIN --}}
{{-- ========================= --}}

    <!-- MAIN CONTENT -->
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- ========================= --}}
    {{--  FOOTER BUYER (HILANG UNTUK ADMIN) --}}
    {{-- ========================= --}}
    @if(!auth()->check() || !auth()->user()->isAdmin())
        <footer class="bg-darker-bg border-t border-border-color">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-lg font-semibold text-accent-green mb-4">MOVR</h3>
                        <p class="text-gray-600">E-commerce sporty terbaik dengan produk premium untuk gaya hidup aktif.</p>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Layanan</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-600 hover:text-accent-green transition">Kebijakan Pengiriman</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-accent-green transition">Kebijakan Pengembalian</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-accent-green transition">FAQ</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tentang Kami</h3>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-gray-600 hover:text-accent-green transition">Tentang MOVR</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-accent-green transition">Karir</a></li>
                            <li><a href="#" class="text-gray-600 hover:text-accent-green transition">Kontak</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ikuti Kami</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-600 hover:text-accent-green transition"><i class="fab fa-instagram text-xl"></i></a>
                            <a href="#" class="text-gray-600 hover:text-accent-green transition"><i class="fab fa-facebook text-xl"></i></a>
                            <a href="#" class="text-gray-600 hover:text-accent-green transition"><i class="fab fa-twitter text-xl"></i></a>
                            <a href="#" class="text-gray-600 hover:text-accent-green transition"><i class="fab fa-youtube text-xl"></i></a>
                        </div>
                    </div>
                </div>

                <div class="border-t border-border-color mt-8 pt-8 text-center text-gray-600">
                    <p>&copy; 2025 MOVR. All rights reserved.</p>
                </div>
            </div>
        </footer>
    @endif
    {{-- END FOOTER --}}
    {{-- ========================= --}}

    <!-- SUCCESS & ERROR -->
    @if(session('status'))
        <div id="alert-message" class="fixed top-4 right-4 bg-accent-green text-white px-4 py-2 rounded-lg shadow-lg z-50">
            {{ session('status') }}
        </div>
        <script>setTimeout(() => document.getElementById('alert-message').style.display = 'none', 3000);</script>
    @endif

    @if(session('error'))
        <div id="alert-error" class="fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50">
            {{ session('error') }}
        </div>
        <script>setTimeout(() => document.getElementById('alert-error').style.display = 'none', 3000);</script>
    @endif

</body>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("userMenuBtn");
    const menu = document.getElementById("userMenu");

    if(btn){
        btn.addEventListener("click", () => menu.classList.toggle("hidden"));
    }

    document.addEventListener("click", (e) => {
        if (btn && !btn.contains(e.target) && menu && !menu.contains(e.target)) {
            menu.classList.add("hidden");
        }
    });
});
</script>

</html>
