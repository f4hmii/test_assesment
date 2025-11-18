# MOVR - E-commerce Sporty

MOVR adalah platform e-commerce sporty dengan tema gelap modern yang dibangun menggunakan Laravel. Platform ini dirancang untuk menyediakan pengalaman belanja yang sporty dan modern dengan antarmuka yang user-friendly dan fungsionalitas yang lengkap.

## Fitur Utama

### User Role
- **Admin** (juga bertindak sebagai penjual)
- **Customer** (role default untuk registrasi)

### Fungsionalitas Customer
- Registrasi dan login
- Browse produk
- Detail produk dengan ulasan
- Add to cart
- Shopping cart management
- Checkout sederhana
- Manajemen profil
- Manajemen alamat (bisa memiliki alamat banyak)
- Favorit produk

### Fungsionalitas Admin
- CRUD produk
- Dashboard admin
- Manajemen pembayaran

## Teknologi yang Digunakan

- Laravel 12
- TailwindCSS
- MySQL
- PHP 8.2+

## Instalasi

1. **Clone repository atau buka project folder**
```bash
cd testaassesment2
```

2. **Install dependencies**
```bash
composer install
npm install
```

3. **Setup environment**
```bash
cp .env.example .env
```

4. **Generate application key**
```bash
php artisan key:generate
```

5. **Setup database**
- Buat database baru di MySQL
- Update `.env` dengan konfigurasi database Anda:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=nama_user
DB_PASSWORD=password
```

6. **Run migrations and seeders**
```bash
php artisan migrate --seed
```

7. **Setup storage link**
```bash
php artisan storage:link
```

8. **Start development server**
```bash
php artisan serve
```

## Struktur Database (Indonesian Naming)

### Tabel Utama
- `users` - Tabel pengguna dengan kolom tambahan `role`
- `produk` - Produk dengan kolom: id, penjual_id, nama_produk, slug, deskripsi, harga, stok, gambar, kategori, timestamps
- `alamat` - Alamat pelanggan: id, pembeli_id, label, provinsi, kota, kecamatan, detail_alamat, kode_pos, is_default, timestamps
- `keranjang_items` - Item keranjang: id, pembeli_id, produk_id, jumlah, harga_saat_ini, timestamps
- `ulasan` - Ulasan produk: id, produk_id, pembeli_id, rating, komentar, timestamps
- `favorit` - Produk favorit: id, pembeli_id, produk_id, timestamps
- `pembayaran` - Data pembayaran: id, pembeli_id, total, status, metode, detail_json, timestamps

## Konfigurasi Seeder

Seeder akan otomatis membuat:
- 1 user admin dengan email `admin@movr.com` dan password `password123`
- Beberapa produk contoh

## Route yang Tersedia

### Guest Routes
- `/` - Home page
- `/produk` - Daftar produk
- `/produk/{slug}` - Detail produk
- `/login` - Login page
- `/register` - Register page

### Authenticated Routes
- `/profil` - Profil user dan manajemen alamat
- `/keranjang` - Shopping cart
- `/checkout` - Proses checkout
- `/favorit` - Produk favorit

### Admin Routes (middleware: role:admin)
- `/admin/dashboard` - Dashboard admin
- `/admin/produk` - CRUD produk

## Struktur Proyek (Indonesian Naming)

### Controller
- `AuthController` - Otentikasi
- `HalamanUtamaController` - Home page
- `ProdukController` - Produk (customer)
- `AdminProdukController` - Produk (admin)
- `KeranjangController` - Shopping cart
- `CheckoutController` - Checkout
- `ProfilPembeliController` - Profil management
- `UlasanController` - Ulasan produk
- `FavoritController` - Produk favorit

### Model
- `Pengguna` - User model
- `Produk` - Produk model
- `Alamat` - Alamat model
- `KeranjangItem` - Keranjang item model
- `Ulasan` - Ulasan model
- `Favorit` - Favorit model
- `Pembayaran` - Pembayaran model

## Desain UI/UX

### Tema Warna
- Background gelap: `#0b0d0f`
- Accent green: `#00bf8f`
- Accent blue: `#00a3ff`
- Card background: `#14171a`
- Border: `#2a2f35`
- Text: `#f0f0f0`

### Animasi
- Hover card effect: `lift effect` (translateY -4px + shadow)
- Button active scale: `scale 0.98`
- Active navbar underline animation

### Font
- Font sans-serif modern yang bold untuk tipografi

## Testing

Untuk menjalankan test:
```bash
php artisan test
```

## License

[MIT License](LICENSE)

## Catatan Pengembangan

- Semua model, controller, migration, variabel, dan route name menggunakan penamaan Bahasa Indonesia
- Menghindari relasi many-to-many, gunakan one-to-many atau pivot model eksplisit
- Validasi server-side menggunakan Form Request (belum sepenuhnya diimplementasikan dalam versi ini)
- Password dihash menggunakan Hash::make()
- Middleware role:admin untuk proteksi route admin
- Admin tidak bisa register, hanya dibuat via seeder
- Registration otomatis assign role="pembeli"

## Penulis

Dibuat sebagai proyek Laravel e-commerce sporty dengan tema gelap.