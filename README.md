# Sistem Perpustakaan Digital Kampus (`app-perpustakaan`)

Aplikasi web untuk petugas dan admin perpustakaan kampus: mengelola data buku, kategori, anggota, serta transaksi peminjaman dan pengembalian buku. Dibangun dengan **Laravel 13** dan **MySQL** sebagai project praktikum mata kuliah Pemrograman Framework (Pertemuan 1-10).

## Fitur

- **Login/logout** berbasis session, dengan dua role:
  - **Admin**: akses penuh, termasuk kelola kategori.
  - **Petugas**: operasional harian (buku, anggota, peminjaman).
- **CRUD buku, kategori, dan anggota**: validasi input, pagination, dan pencarian nama anggota.
- **Peminjaman**:
  - Satu transaksi bisa berisi banyak buku.
  - Petugas pencatat terisi otomatis dari akun yang login.
  - Tombol "Kembalikan" dan badge status berwarna.
- **Dashboard** dan **Laporan Peminjaman**: datanya diambil dari REST API internal (`GET /api/stats`, `GET /api/loans`).
- **REST API** `/api/books`, `/api/members`, `/api/loans`, `/api/stats`. Dokumentasi lengkapnya ada di [`API.md`](API.md).
- **Halaman profil** dengan fitur ganti password.

## Prasyarat

- PHP 8.3+ dan Composer
- MySQL 8+
- Git

Di macOS, ketiganya bisa dipasang lewat Homebrew:

```bash
brew install php composer mysql
brew services start mysql
```

## Instalasi

```bash
# 1. Clone repository
git clone https://github.com/prayogosatrio/app-perpustakaan.git
cd app-perpustakaan

# 2. Install dependency
composer install

# 3. Siapkan file environment
cp .env.example .env
php artisan key:generate
```

Buka `.env`, lalu sesuaikan bagian berikut:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_perpustakaan
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=file
APP_FAKER_LOCALE=id_ID

# Server kedua khusus panggilan API internal (dipakai Dashboard & Laporan)
INTERNAL_API_URL=http://127.0.0.1:8011
```

Buat database, lalu jalankan migration dan seeder:

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS db_perpustakaan;"
php artisan migrate:fresh --seed
```

Seeder mengisi data demo bergaya Indonesia: 3 user, 5 kategori, 20 buku, 15 anggota, dan 10 transaksi peminjaman.

## Menjalankan Aplikasi (Dua Server)

`php artisan serve` hanya memproses **satu request pada satu waktu**. Halaman Dashboard dan Laporan memanggil API milik aplikasi ini sendiri lewat HTTP. Kalau panggilan itu dikirim ke server yang sama, server akan deadlock (saling menunggu). Karena itu, jalankan **dua server di dua terminal terpisah**:

```bash
# Terminal 1 - server utama untuk browser
php artisan serve --port=8000

# Terminal 2 - server khusus panggilan API internal (sesuai INTERNAL_API_URL)
php artisan serve --port=8011
```

Buka `http://127.0.0.1:8000`. Kalau server kedua tidak menyala, aplikasi tetap berjalan: Dashboard menampilkan angka 0 dan Laporan tampil kosong, tanpa error.

## Akun Demo

| Role | Email | Password |
|---|---|---|
| Admin | `admin@pens.ac.id` | `password` |
| Petugas | `petugas1@pens.ac.id` | `password` |
| Petugas | `petugas2@pens.ac.id` | `password` |

## Dokumentasi Lain

- [`API.md`](API.md): dokumentasi seluruh endpoint REST API beserta contoh request/response.
- [`DEMO.md`](DEMO.md): skenario demo aplikasi langkah demi langkah.

## Alur Kerja Git

- `dev`: branch pengembangan aktif. Setiap pertemuan di-commit dengan format `[P-X] deskripsi`.
- `main`: kondisi stabil yang siap didemokan (hasil merge dari `dev`).
