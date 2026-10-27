# Skenario Demo - Sistem Perpustakaan Digital Kampus

Urutan demo aplikasi `app-perpustakaan` dari login sampai demo REST API. Perkiraan durasi sekitar 10-15 menit.

## Persiapan (sebelum demo dimulai)

1. Reset database ke data demo yang bersih:
   ```bash
   php artisan migrate:fresh --seed
   ```
2. Nyalakan **dua** server di dua terminal:
   ```bash
   php artisan serve --port=8000   # browser
   php artisan serve --port=8011   # API internal (Dashboard & Laporan)
   ```
3. Buka Postman dan siapkan collection `app-perpustakaan` dengan base URL `http://127.0.0.1:8000/api` dan header `Accept: application/json`.
4. Buka browser di `http://127.0.0.1:8000`.

## 1. Login

1. Buka `http://127.0.0.1:8000/books` tanpa login. Aplikasi otomatis mengarahkan ke halaman **Login**.
2. Coba login dengan password salah. Muncul pesan *"Email atau password salah."*
3. Login sebagai admin: `admin@pens.ac.id` / `password`.
4. **Hasil:** diarahkan ke Dashboard dengan pesan *"Login berhasil, selamat datang Bambang Sutrisno."* Navbar menampilkan *Bambang Sutrisno (Admin)*.

## 2. Tampilkan Dashboard

1. Tunjukkan tiga kartu statistik: **Total Buku**, **Total Anggota**, dan **Peminjaman Aktif**.
2. Jelaskan bahwa angka ini diambil dari `GET /api/stats` lewat server kedua (port 8011), bukan query database langsung.

## 3. Tambah Kategori

1. Klik menu **Kategori**. Menu ini hanya muncul untuk admin.
2. Klik **+ Tambah Kategori**, lalu klik **Simpan** tanpa mengisi apa pun. Muncul pesan *"Nama kategori wajib diisi."*
3. Isi *Nama Kategori*: `Biografi`, *Deskripsi*: `Kisah hidup tokoh-tokoh inspiratif.`, lalu **Simpan**.
4. **Hasil:** kembali ke daftar kategori dengan pesan sukses, dan kategori *Biografi* muncul di tabel.

## 4. Tambah Buku

1. Klik menu **Buku**, lalu **+ Tambah Buku**.
2. Isi form:
   - Judul: `Habibie & Ainun`
   - Penulis: `B.J. Habibie`
   - Penerbit: `THC Mandiri`
   - Tahun Terbit: `2010`
   - Stok: `3`
   - Kategori: `Biografi`

   Lalu klik **Simpan**.
3. **Hasil:** pesan sukses tampil, dan buku baru ada di daftar dengan kolom kategori *Biografi* (nama, bukan ID).
4. Tunjukkan pagination di bawah tabel, lalu klik halaman **2**.

## 5. Tambah Anggota

1. Klik menu **Anggota**, lalu **+ Tambah Anggota**.
2. Isi form:
   - Nama: `Prayogo Adhi Satrio`
   - NIM: `3125600043`
   - Email: `prayogo@pens.ac.id`
   - Nomor Telepon: `081234567890`
   - Alamat: `Surabaya`
   - Status: `Aktif`

   Lalu klik **Simpan**.
3. Ketik `Prayogo` di kolom pencarian, lalu klik **Cari**. Hanya anggota tersebut yang tampil.

## 6. Buat Peminjaman

1. Klik menu **Peminjaman**, lalu **+ Tambah Peminjaman**.
2. Tunjukkan bahwa **tidak ada dropdown Petugas**. Yang tampil hanya teks *"Petugas pencatat: Bambang Sutrisno (otomatis dari akun yang login)."*
3. Isi form:
   - Anggota: `Prayogo Adhi Satrio (3125600043)`
   - Tanggal Pinjam: hari ini
   - Tanggal Kembali: 7 hari lagi
   - Buku: centang **Habibie & Ainun** dan satu buku lain

   Lalu klik **Simpan**.
4. **Hasil:** transaksi baru muncul di daftar peminjaman dengan nama anggota, nama petugas, dan judul kedua buku, plus badge status **Dipinjam** (kuning).

## 7. Lihat Daftar Peminjaman Aktif

1. Di halaman **Peminjaman**, tunjukkan transaksi berstatus **Dipinjam**. Hanya baris ini yang punya tombol **Kembalikan**.
2. Bandingkan dengan badge **Dikembalikan** (hijau) dan **Terlambat** (merah) di baris lain.
3. Buka **Anggota → Detail** milik *Prayogo Adhi Satrio*. Transaksi tadi muncul di tabel **Riwayat Peminjaman**.

## 8. Proses Pengembalian

1. Kembali ke **Peminjaman**, lalu klik **Kembalikan** pada transaksi milik *Prayogo Adhi Satrio*.
2. **Hasil:** pesan sukses tampil, badge berubah jadi **Dikembalikan**, dan tombol **Kembalikan** hilang.
3. Buka **Detail** transaksi tersebut. *Tanggal Dikembalikan* terisi tanggal hari ini.
4. Buka **Dashboard**. Angka *Peminjaman Aktif* berkurang satu.

## 9. Tampilkan Laporan

1. Klik menu **Laporan** (atau tombol *Lihat Laporan Peminjaman* di Dashboard).
2. Jelaskan bahwa tabel ini diambil dari `GET /api/loans` lewat server kedua, termasuk navigasi halamannya (dibangun dari `meta` response API).

## 10. Hak Akses Petugas

1. Klik **Logout**, lalu login sebagai `petugas1@pens.ac.id` / `password`.
2. Menu **Kategori** tidak muncul di navbar.
3. Ketik `http://127.0.0.1:8000/categories` langsung di address bar. Muncul halaman **403 Forbidden**.

## 11. Demo REST API di Postman

| No | Request | Yang ditunjukkan |
|---|---|---|
| 1 | `GET /books` | Response `data` + `links` + `meta` (pagination), kategori ter-nested |
| 2 | `GET /books?judul=habibie` | Hanya buku yang judulnya cocok |
| 3 | `POST /books` dengan body kosong `{}` | Status **422** dan pesan error per field |
| 4 | `POST /books` dengan body lengkap | Status **201 Created** |
| 5 | `GET /books/999` | Status **404** |
| 6 | `GET /members` | Daftar anggota + pagination |
| 7 | `POST /loans` dengan `member_id`, `user_id`, `tanggal_pinjam`, `tanggal_kembali`, `book_ids` | Status **201**, `status: "dipinjam"` |
| 8 | `PUT /loans/{id}/kembalikan` | `status: "dikembalikan"`, `tanggal_dikembalikan` terisi |
| 9 | `GET /stats` | Angka statistik sama dengan kartu di Dashboard |

Contoh body `POST /books`:

```json
{
    "judul": "Sejarah Indonesia Modern",
    "penulis": "M.C. Ricklefs",
    "penerbit": "Serambi",
    "tahun_terbit": 2008,
    "stok": 2,
    "category_id": 5
}
```

Contoh body `POST /loans` (`user_id` wajib dikirim karena API tidak memakai session login):

```json
{
    "member_id": 1,
    "user_id": 1,
    "tanggal_pinjam": "2026-10-27",
    "tanggal_kembali": "2026-11-03",
    "book_ids": [1, 2]
}
```

## 12. (Opsional) Ketahanan Saat Server API Mati

1. Matikan terminal server port `8011` (Ctrl+C).
2. Refresh **Dashboard** dan **Laporan**. Kedua halaman tetap tampil (angka 0, tabel kosong) tanpa error 500, karena `ConnectionException` ditangkap `try/catch`.
3. Nyalakan lagi server port `8011`.
