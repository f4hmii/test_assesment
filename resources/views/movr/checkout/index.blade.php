@extends('movr.layouts.app')

@section('content')
<!-- Page Header -->
<section class="py-6 bg-darker-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-light-text">Checkout</h1>
    </div>
</section>

<!-- Checkout Content -->
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Checkout Form -->
            <div class="lg:w-2/3">
                <div class="bg-card-bg border border-border-color rounded-lg p-6 mb-8">
                    <h2 class="text-xl font-bold text-light-text mb-6">Alamat Pengiriman</h2>
                    
                    <form method="POST" action="{{ route('checkout.store') }}" id="checkout-form">
                        @csrf
                        
                        @if($alamat->count() > 0)
                            <div class="mb-6">
                                <label class="block text-light-text mb-2">Pilih Alamat Tersimpan</label>
                                @foreach($alamat as $addr)
                                    <div class="flex items-start mb-4">
                                        <input type="radio" id="alamat_{{ $addr->id }}" name="alamat_id" value="{{ $addr->id }}" 
                                            {{ $addr->is_default ? 'checked' : '' }} 
                                            class="mt-1 h-4 w-4 text-accent-green border-border-color focus:ring-accent-green">
                                        <label for="alamat_{{ $addr->id }}" class="ml-3 flex-1">
                                            <div class="text-light-text">{{ $addr->label }}</div>
                                            <div class="text-gray-400 text-sm">{{ $addr->detail_alamat }}, {{ $addr->kecamatan }}, {{ $addr->kota }}, {{ $addr->provinsi }} {{ $addr->kode_pos }}</div>
                                            @if($addr->is_default)
                                                <span class="inline-block mt-1 px-2 py-1 text-xs bg-accent-green text-dark-bg rounded">Alamat Utama</span>
                                            @endif
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="relative border-t border-border-color my-6">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-border-color"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <span class="px-2 bg-card-bg text-gray-500">atau</span>
                                </div>
                            </div>
                        @endif
                        
                        <div class="mb-6">
                            <label class="block text-light-text mb-2">Tambah Alamat Baru</label>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="label" class="block text-sm font-medium text-light-text mb-1">Nama Alamat</label>
                                    <input type="text" id="label" name="label" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                </div>
                                
                                <div>
                                    <label for="is_default" class="flex items-center">
                                        <input type="checkbox" id="is_default" name="is_default" value="1" class="h-4 w-4 text-accent-green border-border-color rounded focus:ring-accent-green">
                                        <span class="ml-2 text-light-text">Jadikan Alamat Utama</span>
                                    </label>
                                </div>
                                
                                <div>
                                    <label for="provinsi" class="block text-sm font-medium text-light-text mb-1">Provinsi</label>
                                    <input type="text" id="provinsi" name="provinsi" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                </div>
                                
                                <div>
                                    <label for="kota" class="block text-sm font-medium text-light-text mb-1">Kota</label>
                                    <input type="text" id="kota" name="kota" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                </div>
                                
                                <div>
                                    <label for="kecamatan" class="block text-sm font-medium text-light-text mb-1">Kecamatan</label>
                                    <input type="text" id="kecamatan" name="kecamatan" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                </div>
                                
                                <div>
                                    <label for="kode_pos" class="block text-sm font-medium text-light-text mb-1">Kode Pos</label>
                                    <input type="text" id="kode_pos" name="kode_pos" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label for="detail_alamat" class="block text-sm font-medium text-light-text mb-1">Alamat Lengkap</label>
                                    <textarea id="detail_alamat" name="detail_alamat" rows="3" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="border-t border-border-color pt-6">
                            <h2 class="text-xl font-bold text-light-text mb-6">Metode Pembayaran</h2>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                                <div class="border border-border-color rounded-lg p-4">
                                    <input type="radio" id="cod" name="metode" value="cod" required class="sr-only peer" checked>
                                    <label for="cod" class="flex flex-col items-center justify-between cursor-pointer p-4 border border-border-color rounded-lg hover:bg-dark-bg peer-checked:border-accent-green peer-checked:bg-dark-bg">
                                        <i class="fas fa-hand-holding-usd text-3xl mb-2 text-accent-green"></i>
                                        <span class="text-light-text">Bayar di Tempat</span>
                                    </label>
                                </div>
                                
                                <div class="border border-border-color rounded-lg p-4">
                                    <input type="radio" id="transfer" name="metode" value="transfer" required class="sr-only peer">
                                    <label for="transfer" class="flex flex-col items-center justify-between cursor-pointer p-4 border border-border-color rounded-lg hover:bg-dark-bg peer-checked:border-accent-green peer-checked:bg-dark-bg">
                                        <i class="fas fa-exchange-alt text-3xl mb-2 text-accent-green"></i>
                                        <span class="text-light-text">Transfer Bank</span>
                                    </label>
                                </div>
                                
                                <div class="border border-border-color rounded-lg p-4">
                                    <input type="radio" id="kartu_kredit" name="metode" value="kartu_kredit" required class="sr-only peer">
                                    <label for="kartu_kredit" class="flex flex-col items-center justify-between cursor-pointer p-4 border border-border-color rounded-lg hover:bg-dark-bg peer-checked:border-accent-green peer-checked:bg-dark-bg">
                                        <i class="fas fa-credit-card text-3xl mb-2 text-accent-green"></i>
                                        <span class="text-light-text">Kartu Kredit</span>
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" class="w-full bg-accent-green text-dark-bg py-3 px-4 rounded-lg text-center font-medium hover:bg-opacity-90 transition btn-scale">
                                <i class="fas fa-check-circle mr-2"></i>Proses Pembayaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:w-1/3">
                <div class="bg-card-bg border border-border-color rounded-lg p-6 sticky top-24">
                    <h2 class="text-xl font-bold text-light-text mb-6">Ringkasan Pesanan</h2>
                    
                    <div class="space-y-4 mb-6">
                        @foreach($keranjangItems as $item)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-400">{{ $item->produk->nama_produk }} x {{ $item->jumlah }}</span>
                                <span class="text-light-text">Rp {{ number_format($item->jumlah * $item->harga_saat_ini, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="border-t border-border-color pt-4 space-y-2">
                        <div class="flex justify-between">
                            <span class="text-light-text">Subtotal</span>
                            <span class="text-light-text">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-light-text">Biaya Pengiriman</span>
                            <span class="text-light-text">Rp 0</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-light-text">Pajak</span>
                            <span class="text-light-text">Rp {{ number_format($total * 0.1, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-border-color pt-2 mt-2">
                            <div class="flex justify-between">
                                <span class="text-lg font-bold text-light-text">Total</span>
                                <span class="text-lg font-bold text-accent-green">Rp {{ number_format($total * 1.1, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle form submission for saving new address
    const form = document.getElementById('checkout-form');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    submitBtn.addEventListener('click', function(e) {
        // Check if user wants to add a new address
        const label = document.getElementById('label').value;
        const provinsi = document.getElementById('provinsi').value;
        const kota = document.getElementById('kota').value;
        const kecamatan = document.getElementById('kecamatan').value;
        const kode_pos = document.getElementById('kode_pos').value;
        const detail_alamat = document.getElementById('detail_alamat').value;
        
        if(label && provinsi && kota && kecamatan && kode_pos && detail_alamat) {
            // If all new address fields are filled, submit the form to store the address first
            e.preventDefault();
            
            // Submit the address to be stored
            fetch('{{ route('profil.alamat.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    label: label,
                    provinsi: provinsi,
                    kota: kota,
                    kecamatan: kecamatan,
                    kode_pos: kode_pos,
                    detail_alamat: detail_alamat,
                    is_default: document.getElementById('is_default').checked ? 1 : 0
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // After successfully storing the address, redirect back to checkout to select it
                    window.location.reload();
                } else {
                    alert('Gagal menyimpan alamat baru');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat menyimpan alamat');
            });
        }
    });
});
</script>
@endsection