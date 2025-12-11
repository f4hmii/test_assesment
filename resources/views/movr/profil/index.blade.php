@extends('movr.layouts.app')

@section('content')
<!-- Page Header -->
<section class="py-12 bg-light">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-bold text-black">Profil Saya</h1>
        <p class="mt-2 text-gray-600">Kelola informasi profil dan alamat Anda</p>
    </div>
</section>

<!-- Profile Content -->
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Information -->
            <div class="lg:col-span-2">
                <div class="bg-white border border-gray-300 rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-black mb-6">Informasi Profil</h3>

                    @if(session('status'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-500 rounded-lg text-green-700">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-500 rounded-lg text-red-700">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('profil.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-black mb-2">Nama</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-black focus:ring-accent-green focus:border-accent-green" required>
                            @error('name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block text-sm font-medium text-black mb-2">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-black focus:ring-accent-green focus:border-accent-green" required>
                            @error('email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit" class="bg-accent-green text-white px-6 py-2 rounded-lg hover:bg-accent-green/90 transition btn-scale">
                            Simpan Perubahan
                        </button>
                    </form>

                    <hr class="my-6 border-gray-300">

                    <h4 class="text-lg font-medium text-black mb-4">Ubah Kata Sandi</h4>
                    <form action="{{ route('profil.password.update') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="current_password" class="block text-sm font-medium text-black mb-2">Kata Sandi Saat Ini</label>
                            <input type="password" id="current_password" name="current_password" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-black focus:ring-accent-green focus:border-accent-green" required>
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_password" class="block text-sm font-medium text-black mb-2">Kata Sandi Baru</label>
                            <input type="password" id="new_password" name="new_password" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-black focus:ring-accent-green focus:border-accent-green" required>
                            @error('new_password')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="new_password_confirmation" class="block text-sm font-medium text-black mb-2">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-black focus:ring-accent-green focus:border-accent-green" required>
                        </div>

                        <button type="submit" class="bg-accent-green text-white px-6 py-2 rounded-lg hover:bg-accent-green/90 transition btn-scale">
                            Ubah Kata Sandi
                        </button>
                    </form>
                </div>
            </div>

            <!-- Addresses -->
            <div>
                <div class="bg-white border border-gray-300 rounded-lg p-6 mb-6">
                    <h3 class="text-xl font-semibold text-black mb-6">Riwayat Pesanan</h3>
                    <div class="mb-4">
                        <a href="{{ route('customer.dashboard') }}" class="w-full bg-accent-green text-white py-3 rounded-lg font-bold hover:bg-accent-green/90 transition block text-center">
                            Lihat Riwayat Pesanan
                        </a>
                    </div>
                </div>

                <div class="bg-white border border-gray-300 rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-black mb-6">Alamat Pengiriman</h3>

                    @foreach($alamat as $item)
                        <div class="mb-4 p-4 bg-gray-100 rounded-lg">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-black">{{ $item->label }}</h4>
                                    <p class="text-sm text-gray-600 mt-1">
                                        {{ $item->detail_alamat }}, {{ $item->kecamatan }}, {{ $item->kota }}, {{ $item->provinsi }} {{ $item->kode_pos }}
                                    </p>
                                    @if($item->is_default)
                                        <span class="inline-block mt-2 px-2 py-1 bg-accent-green text-white text-xs rounded">Alamat Utama</span>
                                    @endif
                                </div>
                                <div class="flex space-x-2">
                                    <button onclick="editAlamat({{ $item->id }})" class="text-accent-green hover:text-green-700">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('profil.alamat.destroy', $item->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700" onclick="return confirm('Apakah Anda yakin ingin menghapus alamat ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <button onclick="addAlamat()" class="w-full bg-white border border-gray-300 text-black py-2 rounded-lg hover:bg-gray-100 transition btn-scale">
                        <i class="fas fa-plus mr-2"></i>Tambah Alamat
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal for Add/Edit Address -->
<div id="alamatModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <h3 id="modalTitle" class="text-xl font-semibold text-black mb-4">Tambah Alamat</h3>
            <form id="alamatForm" action="{{ route('profil.alamat.store') }}" method="POST">
                @csrf
                <input type="hidden" id="alamatId" name="id">

                <div class="mb-4">
                    <label for="label" class="block text-sm font-medium text-black mb-2">Label Alamat</label>
                    <input type="text" id="label" name="label" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-black focus:ring-accent-green focus:border-accent-green" required>
                </div>

                <div class="mb-4">
                    <label for="provinsi" class="block text-sm font-medium text-black mb-2">Provinsi</label>
                    <input type="text" id="provinsi" name="provinsi" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-black focus:ring-accent-green focus:border-accent-green" required>
                </div>

                <div class="mb-4">
                    <label for="kota" class="block text-sm font-medium text-black mb-2">Kota</label>
                    <input type="text" id="kota" name="kota" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-black focus:ring-accent-green focus:border-accent-green" required>
                </div>

                <div class="mb-4">
                    <label for="kecamatan" class="block text-sm font-medium text-black mb-2">Kecamatan</label>
                    <input type="text" id="kecamatan" name="kecamatan" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-black focus:ring-accent-green focus:border-accent-green" required>
                </div>

                <div class="mb-4">
                    <label for="detail_alamat" class="block text-sm font-medium text-black mb-2">Detail Alamat</label>
                    <textarea id="detail_alamat" name="detail_alamat" rows="3" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-black focus:ring-accent-green focus:border-accent-green" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="kode_pos" class="block text-sm font-medium text-black mb-2">Kode Pos</label>
                    <input type="text" id="kode_pos" name="kode_pos" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-lg text-black focus:ring-accent-green focus:border-accent-green" required>
                </div>

                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="hidden" name="is_default" value="0">
                        <input type="checkbox" id="is_default" name="is_default" value="1" class="rounded bg-white border-gray-300 text-accent-green focus:ring-accent-green">
                        <span class="ml-2 text-black">Jadikan alamat utama</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-accent-green text-white rounded-lg hover:bg-accent-green/90 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function addAlamat() {
    document.getElementById('modalTitle').textContent = 'Tambah Alamat';
    document.getElementById('alamatForm').action = '{{ route('profil.alamat.store') }}';
    document.getElementById('alamatForm').method = 'POST';
    document.getElementById('alamatId').value = '';
    document.getElementById('alamatModal').classList.remove('hidden');
}

function submitAlamat(id) {
    document.getElementById('modalTitle').textContent = 'Edit Alamat';
    document.getElementById('alamatForm').action = '{{ route('profil.alamat.edit', ':id') }}'.replace(':id', id);
    document.getElementById('alamatForm').method = 'GET';
    document.getElementById('alamatId').value = id;

    // Here you would typically fetch the address data via AJAX and populate the form
    // For simplicity, this is left as a placeholder

    document.getElementById('alamatModal').classList.remove('hidden');
}

function editAlamat(id) {
    document.getElementById('modalTitle').textContent = 'Tambah Alamat';

    fetch(`/profil/alamat/${id}`)
        .then(res => res.json())
        .then(data => {

            // Isi field sesuai struktur form kamu
            document.getElementById('alamatId').value = data.id;
            document.getElementById('label').value = data.label;
            document.getElementById('provinsi').value = data.provinsi;
            document.getElementById('kota').value = data.kota;
            document.getElementById('kecamatan').value = data.kecamatan;
            document.getElementById('detail_alamat').value = data.detail_alamat;
            document.getElementById('kode_pos').value = data.kode_pos;
            document.getElementById('is_default').checked = data.is_default == 1;

            // Ganti action form ke route update
            const form = document.getElementById('alamatForm');
            form.action =  '{{ route('profil.alamat.edit', ':id') }}'.replace(':id', id);// misal route update POST/PUT /alamat/{id}`

            // Karena form awalnya untuk CREATE, kita tambahkan method override untuk UPDATE
            let methodInput = document.getElementById('_method_override');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.id = '_method_override';
                form.appendChild(methodInput);
            }
            methodInput.value = 'PUT';

            // Tampilkan modal
            document.getElementById('alamatModal').classList.remove('hidden');
        })
        .catch(err => console.error('Error: ', err));
}
function closeModal() {
    document.getElementById('alamatModal').classList.add('hidden');
}
</script>
@endsection
