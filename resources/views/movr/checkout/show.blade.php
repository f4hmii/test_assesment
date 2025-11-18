@extends('movr.layouts.app')

@section('content')
<!-- Page Header -->
<section class="py-6 bg-darker-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-light-text">Detail Pembayaran</h1>
    </div>
</section>

<!-- Payment Details -->
<section class="py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-card-bg border border-border-color rounded-lg p-6">
            <div class="text-center mb-8">
                <i class="fas fa-check-circle text-accent-green text-6xl mb-4"></i>
                <h2 class="text-2xl font-bold text-light-text mb-2">Pembayaran Berhasil!</h2>
                <p class="text-gray-400">Terima kasih atas pesanan Anda. ID Pembayaran: #{{ $pembayaran->id }}</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-semibold text-light-text mb-4">Detail Pengiriman</h3>
                    @if($alamat)
                        <div class="bg-dark-bg border border-border-color rounded-lg p-4">
                            <p class="text-light-text">{{ $alamat->label }}</p>
                            <p class="text-gray-400">{{ $alamat->detail_alamat }}, {{ $alamat->kecamatan }}, {{ $alamat->kota }}, {{ $alamat->provinsi }} {{ $alamat->kode_pos }}</p>
                            @if($alamat->is_default)
                                <span class="inline-block mt-2 px-2 py-1 text-xs bg-accent-green text-dark-bg rounded">Alamat Utama</span>
                            @endif
                        </div>
                    @else
                        <p class="text-gray-400">Alamat tidak ditemukan</p>
                    @endif
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-light-text mb-4">Metode Pembayaran</h3>
                    <div class="bg-dark-bg border border-border-color rounded-lg p-4">
                        <p class="text-light-text capitalize">{{ $pembayaran->metode }}</p>
                        <p class="text-gray-400 mt-2">Status: 
                            @switch($pembayaran->status)
                                @case('pending')
                                    <span class="text-yellow-500">Menunggu Pembayaran</span>
                                    @break
                                @case('diproses')
                                    <span class="text-blue-500">Diproses</span>
                                    @break
                                @case('dikirim')
                                    <span class="text-accent-blue">Dikirim</span>
                                    @break
                                @case('selesai')
                                    <span class="text-accent-green">Selesai</span>
                                    @break
                                @case('dibatalkan')
                                    <span class="text-red-500">Dibatalkan</span>
                                    @break
                                @default
                                    <span class="text-gray-400">{{ $pembayaran->status }}</span>
                            @endswitch
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-light-text mb-4">Rincian Produk</h3>
                <div class="bg-dark-bg border border-border-color rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-border-color">
                        <thead class="bg-card-bg">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Produk</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Jumlah</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Harga</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-border-color">
                            @if(isset($pembayaran->detail_json['items']) && is_array($pembayaran->detail_json['items']))
                                @foreach($pembayaran->detail_json['items'] as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-light-text">{{ $item['nama_produk'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-light-text">{{ $item['jumlah'] }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-light-text">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-light-text">Rp {{ number_format($item['jumlah'] * $item['harga'], 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-8 border-t border-border-color pt-6">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                    <div>
                        <p class="text-xl font-bold text-light-text">Total Pembayaran</p>
                        <p class="text-2xl font-bold text-accent-green">Rp {{ number_format($pembayaran->total, 0, ',', '.') }}</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('profil.index') }}" class="inline-block bg-accent-green text-dark-bg py-2 px-6 rounded-lg font-medium hover:bg-opacity-90 transition mr-4">
                            Lihat Pesanan Saya
                        </a>
                        <a href="{{ route('home') }}" class="inline-block bg-dark-bg border border-border-color text-light-text py-2 px-6 rounded-lg font-medium hover:bg-card-bg transition">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection