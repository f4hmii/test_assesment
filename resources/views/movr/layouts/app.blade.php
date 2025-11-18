<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MOVR - E-commerce Sporty</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-bg': '#0b0d0f',
                        'darker-bg': '#080a0c',
                        'light-text': '#f0f0f0',
                        'accent-green': '#00bf8f',
                        'accent-blue': '#00a3ff',
                        'card-bg': '#14171a',
                        'border-color': '#2a2f35',
                    }
                }
            }
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-dark-bg text-light-text min-h-screen flex flex-col">
    <!-- Navigation -->
    <nav class="bg-darker-bg border-b border-border-color sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-accent-green">
                        <i class="fas fa-running mr-2"></i>MOVR
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="flex-1 mx-8">
                    <div class="relative">
                        <input type="text" placeholder="Cari produk..." class="w-full bg-card-bg border border-border-color rounded-full py-2 px-4 pl-10 text-white focus:outline-none focus:ring-2 focus:ring-accent-green">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>

                <!-- Navigation Items -->
                <div class="flex items-center space-x-6">
                    @auth
                        <!-- Cart -->
                        <a href="{{ route('keranjang.index') }}" class="text-light-text hover:text-accent-green transition">
                            <i class="fas fa-shopping-cart text-xl relative">
                                @if(auth()->user()->keranjangItems()->count() > 0)
                                    <span class="absolute -top-2 -right-2 bg-accent-green text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                        {{ auth()->user()->keranjangItems()->count() }}
                                    </span>
                                @endif
                            </i>
                        </a>
                        
                        <!-- Favorites -->
                        <a href="{{ route('favorit.index') }}" class="text-light-text hover:text-accent-green transition">
                            <i class="fas fa-heart text-xl"></i>
                        </a>
                        
                        <!-- Profile -->
                        <div class="relative group">
                            <button class="flex items-center space-x-1 text-light-text hover:text-accent-green transition">
                                <i class="fas fa-user text-xl"></i>
                                <i class="fas fa-chevron-down text-sm"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-card-bg border border-border-color rounded-md shadow-lg py-1 hidden group-hover:block z-50">
                                <a href="{{ route('profil.index') }}" class="block px-4 py-2 text-sm hover:bg-dark-bg">Profil Saya</a>
                                <a href="{{ route('keranjang.index') }}" class="block px-4 py-2 text-sm hover:bg-dark-bg">Keranjang</a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm hover:bg-dark-bg">Admin Dashboard</a>
                                @endif
                                 <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="w-full text-left block px-4 py-2 text-sm hover:bg-dark-bg">
                Logout
            </button>
        </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-light-text hover:text-accent-green transition">Login</a>
                        <a href="{{ route('register') }}" class="text-light-text hover:text-accent-green transition">Register</a>
                    @endauth
                </div>
            </div>
        </div>
        
        <!-- Secondary Navigation -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-darker-bg border-t border-border-color">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-accent-green mb-4">MOVR</h3>
                    <p class="text-gray-400">E-commerce sporty terbaik dengan produk premium untuk gaya hidup aktif.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-light-text mb-4">Layanan</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition">Kebijakan Pengiriman</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition">Kebijakan Pengembalian</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition">FAQ</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-light-text mb-4">Tentang Kami</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition">Tentang MOVR</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition">Karir</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-accent-green transition">Kontak</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-light-text mb-4">Ikuti Kami</h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-accent-green transition"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-accent-green transition"><i class="fab fa-facebook text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-accent-green transition"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-accent-green transition"><i class="fab fa-youtube text-xl"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-border-color mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 MOVR. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Success/Error Messages -->
    @if(session('status'))
        <div id="alert-message" class="fixed top-4 right-4 bg-accent-green text-white px-4 py-2 rounded-lg shadow-lg z-50">
            {{ session('status') }}
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('alert-message').style.display = 'none';
            }, 3000);
        </script>
    @endif

    @if(session('error'))
        <div id="alert-error" class="fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50">
            {{ session('error') }}
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('alert-error').style.display = 'none';
            }, 3000);
        </script>
    @endif
</body>
</html>