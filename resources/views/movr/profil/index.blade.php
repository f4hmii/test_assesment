@extends('movr.layouts.app')

@section('content')
<!-- Page Header -->
<section class="py-6 bg-darker-bg">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-bold text-light-text">Profil Saya</h1>
    </div>
</section>

<!-- Profile Content -->
<section class="py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Left Column -->
            <div class="lg:w-1/3">
                <!-- Profile Card -->
                <div class="bg-card-bg border border-border-color rounded-lg p-6 mb-8">
                    <div class="text-center">
                        <div class="mx-auto h-24 w-24 rounded-full bg-dark-bg border border-border-color flex items-center justify-center">
                            <i class="fas fa-user text-accent-green text-3xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-light-text mt-4">{{ $user->name }}</h2>
                        <p class="text-gray-400">{{ $user->email }}</p>
                        <p class="mt-2 text-sm">
                            <span class="inline-block px-3 py-1 rounded-full bg-dark-bg text-accent-green text-xs">
                                {{ $user->role === 'admin' ? 'Admin' : 'Pembeli' }}
                            </span>
                        </p>
                    </div>
                    
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-light-text mb-4">Statistik Akun</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-dark-bg border border-border-color rounded-lg p-4 text-center">
                                <p class="text-2xl font-bold text-accent-green">{{ $user->keranjangItems->count() }}</p>
                                <p class="text-sm text-gray-400">Keranjang</p>
                            </div>
                            <div class="bg-dark-bg border border-border-color rounded-lg p-4 text-center">
                                <p class="text-2xl font-bold text-accent-green">{{ $user->favorit->count() }}</p>
                                <p class="text-sm text-gray-400">Favorit</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Change Password -->
                <div class="bg-card-bg border border-border-color rounded-lg p-6">
                    <h3 class="text-lg font-medium text-light-text mb-4">Ganti Kata Sandi</h3>
                    <form method="POST" action="{{ route('profil.password.update') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="current_password" class="block text-sm font-medium text-light-text mb-1">Kata Sandi Saat Ini</label>
                            <input type="password" id="current_password" name="current_password" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="new_password" class="block text-sm font-medium text-light-text mb-1">Kata Sandi Baru</label>
                            <input type="password" id="new_password" name="new_password" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                            @error('new_password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-6">
                            <label for="new_password_confirmation" class="block text-sm font-medium text-light-text mb-1">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                        </div>
                        
                        <button type="submit" class="w-full bg-accent-green text-dark-bg py-2 px-4 rounded-lg font-medium hover:bg-opacity-90 transition">
                            Ganti Kata Sandi
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Right Column -->
            <div class="lg:w-2/3">
                <!-- Edit Profile Form -->
                <div class="bg-card-bg border border-border-color rounded-lg p-6 mb-8">
                    <h3 class="text-lg font-medium text-light-text mb-4">Edit Profil</h3>
                    <form method="POST" action="{{ route('profil.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-light-text mb-1">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="email" class="block text-sm font-medium text-light-text mb-1">Alamat Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                @error('email')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <button type="submit" class="bg-accent-green text-dark-bg py-2 px-6 rounded-lg font-medium hover:bg-opacity-90 transition">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Manage Addresses -->
                <div class="bg-card-bg border border-border-color rounded-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-light-text">Alamat Saya</h3>
                        <button type="button" onclick="toggleAddressForm()" class="bg-accent-green text-dark-bg py-2 px-4 rounded-lg text-sm font-medium hover:bg-opacity-90 transition">
                            Tambah Alamat
                        </button>
                    </div>
                    
                    <!-- Add Address Form -->
                    <div id="address-form" class="mb-8 hidden">
                        <form method="POST" action="{{ route('profil.alamat.store') }}">
                            @csrf
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label for="label" class="block text-sm font-medium text-light-text mb-1">Nama Alamat</label>
                                    <input type="text" id="label" name="label" value="{{ old('label') }}" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                </div>
                                
                                <div class="flex items-end">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="is_default" name="is_default" value="1" class="h-4 w-4 text-accent-green border-border-color rounded focus:ring-accent-green">
                                        <label for="is_default" class="ml-2 text-light-text">Jadikan Alamat Utama</label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label for="provinsi" class="block text-sm font-medium text-light-text mb-1">Provinsi</label>
                                    <input type="text" id="provinsi" name="provinsi" value="{{ old('provinsi') }}" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                </div>
                                
                                <div>
                                    <label for="kota" class="block text-sm font-medium text-light-text mb-1">Kota</label>
                                    <input type="text" id="kota" name="kota" value="{{ old('kota') }}" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                </div>
                                
                                <div>
                                    <label for="kecamatan" class="block text-sm font-medium text-light-text mb-1">Kecamatan</label>
                                    <input type="text" id="kecamatan" name="kecamatan" value="{{ old('kecamatan') }}" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                </div>
                                
                                <div>
                                    <label for="kode_pos" class="block text-sm font-medium text-light-text mb-1">Kode Pos</label>
                                    <input type="text" id="kode_pos" name="kode_pos" value="{{ old('kode_pos') }}" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label for="detail_alamat" class="block text-sm font-medium text-light-text mb-1">Alamat Lengkap</label>
                                    <textarea id="detail_alamat" name="detail_alamat" rows="3" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-3 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">{{ old('detail_alamat') }}</textarea>
                                </div>
                            </div>
                            
                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="toggleAddressForm()" class="bg-dark-bg border border-border-color text-light-text py-2 px-6 rounded-lg font-medium hover:bg-card-bg transition">
                                    Batal
                                </button>
                                <button type="submit" class="bg-accent-green text-dark-bg py-2 px-6 rounded-lg font-medium hover:bg-opacity-90 transition">
                                    Simpan Alamat
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Address List -->
                    <div class="space-y-4">
                        @forelse($alamat as $addr)
                            <div class="border border-border-color rounded-lg p-4">
                                <div class="flex justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center">
                                            <h4 class="font-medium text-light-text">{{ $addr->label }}</h4>
                                            @if($addr->is_default)
                                                <span class="ml-2 inline-block px-2 py-1 text-xs bg-accent-green text-dark-bg rounded">Alamat Utama</span>
                                            @endif
                                        </div>
                                        <p class="text-gray-400 mt-1">{{ $addr->detail_alamat }}, {{ $addr->kecamatan }}, {{ $addr->kota }}, {{ $addr->provinsi }} {{ $addr->kode_pos }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button type="button" onclick="toggleEditForm({{ $addr->id }})" class="text-accent-green hover:text-accent-green">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <form action="{{ route('profil.alamat.destroy', $addr->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-400" onclick="return confirm('Apakah Anda yakin ingin menghapus alamat ini?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                
                                <!-- Edit Address Form (Initially Hidden) -->
                                <div id="edit-form-{{ $addr->id }}" class="mt-4 hidden">
                                    <form method="POST" action="{{ route('profil.alamat.update', $addr->id) }}">
                                        @csrf
                                        @method('PUT')
                                        
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                            <div>
                                                <label for="edit_label_{{ $addr->id }}" class="block text-sm font-medium text-light-text mb-1">Nama Alamat</label>
                                                <input type="text" id="edit_label_{{ $addr->id }}" name="label" value="{{ $addr->label }}" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-2 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                            </div>
                                            
                                            <div class="flex items-end">
                                                <div class="flex items-center">
                                                    <input type="checkbox" id="edit_is_default_{{ $addr->id }}" name="is_default" value="1" {{ $addr->is_default ? 'checked' : '' }} class="h-4 w-4 text-accent-green border-border-color rounded focus:ring-accent-green">
                                                    <label for="edit_is_default_{{ $addr->id }}" class="ml-2 text-light-text">Jadikan Alamat Utama</label>
                                                </div>
                                            </div>
                                            
                                            <div>
                                                <label for="edit_provinsi_{{ $addr->id }}" class="block text-sm font-medium text-light-text mb-1">Provinsi</label>
                                                <input type="text" id="edit_provinsi_{{ $addr->id }}" name="provinsi" value="{{ $addr->provinsi }}" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-2 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                            </div>
                                            
                                            <div>
                                                <label for="edit_kota_{{ $addr->id }}" class="block text-sm font-medium text-light-text mb-1">Kota</label>
                                                <input type="text" id="edit_kota_{{ $addr->id }}" name="kota" value="{{ $addr->kota }}" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-2 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                            </div>
                                            
                                            <div>
                                                <label for="edit_kecamatan_{{ $addr->id }}" class="block text-sm font-medium text-light-text mb-1">Kecamatan</label>
                                                <input type="text" id="edit_kecamatan_{{ $addr->id }}" name="kecamatan" value="{{ $addr->kecamatan }}" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-2 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                            </div>
                                            
                                            <div>
                                                <label for="edit_kode_pos_{{ $addr->id }}" class="block text-sm font-medium text-light-text mb-1">Kode Pos</label>
                                                <input type="text" id="edit_kode_pos_{{ $addr->id }}" name="kode_pos" value="{{ $addr->kode_pos }}" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-2 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">
                                            </div>
                                            
                                            <div class="md:col-span-2">
                                                <label for="edit_detail_alamat_{{ $addr->id }}" class="block text-sm font-medium text-light-text mb-1">Alamat Lengkap</label>
                                                <textarea id="edit_detail_alamat_{{ $addr->id }}" name="detail_alamat" rows="2" class="w-full bg-dark-bg border border-border-color rounded-lg px-4 py-2 text-light-text focus:outline-none focus:ring-accent-green focus:border-accent-green">{{ $addr->detail_alamat }}</textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="flex justify-end space-x-3">
                                            <button type="button" onclick="toggleEditForm({{ $addr->id }})" class="bg-dark-bg border border-border-color text-light-text py-2 px-4 rounded-lg text-sm font-medium hover:bg-card-bg transition">
                                                Batal
                                            </button>
                                            <button type="submit" class="bg-accent-green text-dark-bg py-2 px-4 rounded-lg text-sm font-medium hover:bg-opacity-90 transition">
                                                Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <i class="fas fa-map-marker-alt text-4xl text-gray-500 mb-4"></i>
                                <p class="text-gray-400">Anda belum memiliki alamat tersimpan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
function toggleAddressForm() {
    const form = document.getElementById('address-form');
    form.classList.toggle('hidden');
}

function toggleEditForm(id) {
    const form = document.getElementById('edit-form-' + id);
    form.classList.toggle('hidden');
}
</script>
@endsection