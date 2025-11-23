@extends('movr.layouts.app')

@section('content')
<section class="py-12 bg-dark-bg min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-center mb-8">
            <a href="{{ route('home') }}" class="text-gray-400 hover:text-white mr-4 transition">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-light-text">Checkout</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-card-bg border border-border-color rounded-xl p-6">
                    <h2 class="text-xl font-bold text-light-text mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-full bg-accent-green text-dark-bg flex items-center justify-center text-sm font-bold mr-3">1</span>
                        Alamat Pengiriman
                    </h2>
                    
                    <form>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-400 text-sm mb-2 font-medium">Nama Penerima</label>
                                <input type="text" value="{{ Auth::user()->name }}" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:border-accent-green transition">
                            </div>
                            <div>
                                <label class="block text-gray-400 text-sm mb-2 font-medium">Nomor Telepon</label>
                                <input type="text" placeholder="Contoh: 08123456789" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:border-accent-green transition">
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-400 text-sm mb-2 font-medium">Alamat Lengkap</label>
                            <textarea rows="3" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:border-accent-green transition" placeholder="Nama Jalan, No Rumah, Kecamatan, Kota..."></textarea>
                        </div>
                    </form>
                </div>

                <div class="bg-card-bg border border-border-color rounded-xl p-6">
                    <h2 class="text-xl font-bold text-light-text mb-6 flex items-center">
                        <span class="w-8 h-8 rounded-full bg-accent-green text-dark-bg flex items-center justify-center text-sm font-bold mr-3">2</span>
                        Metode Pembayaran
                    </h2>
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border border-accent-green rounded-lg cursor-pointer bg-dark-bg/50 transition relative overflow-hidden group">
                            <input type="radio" name="payment" class="text-accent-green focus:ring-accent-green w-4 h-4" checked>
                            <div class="ml-4">
                                <span class="block text-light-text font-bold group-hover:text-accent-green transition">Transfer Bank</span>
                                <span class="text-gray-400 text-sm">BCA, Mandiri, BRI, BNI</span>
                            </div>
                            <i class="fas fa-university ml-auto text-gray-500 group-hover:text-accent-green transition"></i>
                        </label>
                        
                        <label class="flex items-center p-4 border border-border-color rounded-lg cursor-pointer bg-dark-bg hover:border-accent-green transition relative overflow-hidden group">
                            <input type="radio" name="payment" class="text-accent-green focus:ring-accent-green w-4 h-4">
                            <div class="ml-4">
                                <span class="block text-light-text font-bold group-hover:text-accent-green transition">E-Wallet</span>
                                <span class="text-gray-400 text-sm">GoPay, OVO, Dana</span>
                            </div>
                            <i class="fas fa-wallet ml-auto text-gray-500 group-hover:text-accent-green transition"></i>
                        </label>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="bg-card-bg border border-border-color rounded-xl p-6 sticky top-6 shadow-xl">
                    <h2 class="text-lg font-bold text-light-text mb-4 border-b border-border-color pb-4">Ringkasan Pesanan</h2>

                    <div class="space-y-4 mb-6 border-b border-border-color pb-6">
                        @foreach($items as $item)
                        <div class="flex gap-4 items-center">
                            <div class="w-16 h-16 bg-dark-bg rounded-lg overflow-hidden border border-border-color flex-shrink-0">
                                @if(isset($item['image']) && $item['image'])
                                    <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-500"><i class="fas fa-image"></i></div>
                                @endif
                            </div>
                            <div class="flex-1 overflow-hidden">
                                <h3 class="text-light-text font-medium text-sm truncate">{{ $item['name'] }}</h3>
                                <p class="text-gray-400 text-xs mt-1">{{ $item['qty'] }} x Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                            </div>
                            <div class="text-accent-green font-bold text-sm">
                                Rp {{ number_format($item['total'], 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-400 text-sm">
                            <span>Subtotal Produk</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-400 text-sm">
                            <span>Ongkos Kirim</span>
                            <span>Rp {{ number_format($shippingCost, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-gray-400 text-sm">
                            <span>Biaya Layanan</span>
                            <span>Rp {{ number_format($serviceFee, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <div class="border-t border-dashed border-border-color pt-4 mb-6">
                        <div class="flex justify-between items-end">
                            <span class="text-light-text font-bold">Total Bayar</span>
                            <span class="text-2xl font-bold text-accent-green">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <button class="w-full bg-accent-green text-dark-bg py-3.5 rounded-xl font-bold hover:bg-opacity-90 transition shadow-lg shadow-accent-green/20 lift-effect">
                        Bayar Sekarang
                    </button>
                    
                    <div class="mt-4 flex justify-center items-center text-xs text-gray-500 bg-dark-bg/50 py-2 rounded">
                        <i class="fas fa-lock mr-2"></i> Pembayaran Aman & Terenkripsi
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection