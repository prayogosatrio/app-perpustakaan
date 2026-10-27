# Dokumentasi REST API - Sistem Perpustakaan Digital Kampus

Base URL: `http://127.0.0.1:8000/api` (sesuaikan port dengan `php artisan serve`).

Setiap request menyertakan header `Accept: application/json`. Untuk `POST`/`PUT` dengan body, tambahkan juga `Content-Type: application/json`. Seluruh endpoint saat ini bersifat publik (belum memakai autentikasi token).

Contoh response di bawah adalah hasil pemanggilan nyata ke endpoint dengan data contoh, sehingga nilai `id` dan `created_at`/`updated_at` akan berbeda dengan data di database lain. URL di bagian `links` pagination ditulis dengan port `8000`.

## Ringkasan Endpoint

| No | Method | URL | Body (jika ada) | Status Code | Contoh Response |
|---|---|---|---|---|---|
| 1 | `GET` | `/api/books` | - | 200 | [lihat](#1-get-apibooks) |
| 2 | `GET` | `/api/books/{id}` | - | 200 / 404 | [lihat](#2-get-apibooksid) |
| 3 | `POST` | `/api/books` | `judul`, `penulis`, `penerbit`, `tahun_terbit`, `isbn` (opsional), `stok`, `category_id` | 201 / 422 | [lihat](#3-post-apibooks) |
| 4 | `PUT` | `/api/books/{id}` | Sama seperti POST /api/books | 200 / 422 | [lihat](#4-put-apibooksid) |
| 5 | `DELETE` | `/api/books/{id}` | - | 200 / 404 | [lihat](#5-delete-apibooksid) |
| 6 | `GET` | `/api/members` | - | 200 | [lihat](#6-get-apimembers) |
| 7 | `GET` | `/api/members/{id}` | - | 200 / 404 | [lihat](#7-get-apimembersid) |
| 8 | `GET` | `/api/loans` | - | 200 | [lihat](#8-get-apiloans) |
| 9 | `POST` | `/api/loans` | `member_id`, `user_id`, `tanggal_pinjam`, `tanggal_kembali`, `book_ids` (array) | 201 / 422 | [lihat](#9-post-apiloans) |
| 10 | `PUT` | `/api/loans/{id}/kembalikan` | - | 200 / 404 | [lihat](#10-put-apiloansidkembalikan) |
| 11 | `GET` | `/api/stats` | - | 200 | [lihat](#11-get-apistats) |

Keterangan status code: `200 OK` sukses membaca/memperbarui/menghapus, `201 Created` sukses membuat data baru, `404 Not Found` data dengan id tersebut tidak ada, `422 Unprocessable Entity` data gagal validasi (detail per field ada di `errors`).

## Detail Endpoint

### 1. GET /api/books

Daftar buku (pagination 10 per halaman). Query opsional: `?judul=` (pencarian sebagian) dan `?category_id=` (cocok persis).

**Semua buku** - `GET /api/books` → `200 OK`

Response:

```json
{
    "data": [
        {
            "id": 1,
            "judul": "Laskar Pelangi",
            "penulis": "Andrea Hirata",
            "penerbit": "Bentang Pustaka",
            "tahun_terbit": 2005,
            "isbn": "9789793062792",
            "stok": 5,
            "sampul": null,
            "category": {
                "id": 1,
                "nama_kategori": "Fiksi"
            },
            "created_at": "2026-10-27T04:11:16.000000Z",
            "updated_at": "2026-10-27T04:11:16.000000Z"
        },
        {
            "id": 2,
            "judul": "Clean Code",
            "penulis": "Robert C. Martin",
            "penerbit": "Prentice Hall",
            "tahun_terbit": 2008,
            "isbn": "9780132350884",
            "stok": 3,
            "sampul": null,
            "category": {
                "id": 2,
                "nama_kategori": "Teknologi"
            },
            "created_at": "2026-10-27T04:11:16.000000Z",
            "updated_at": "2026-10-27T04:11:16.000000Z"
        }
    ],
    "links": {
        "first": "http://127.0.0.1:8000/api/books?page=1",
        "last": "http://127.0.0.1:8000/api/books?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "page": null,
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/books?page=1",
                "label": "1",
                "page": 1,
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "page": null,
                "active": false
            }
        ],
        "path": "http://127.0.0.1:8000/api/books",
        "per_page": 10,
        "to": 2,
        "total": 2
    }
}
```


**Filter judul** - `GET /api/books?judul=laskar` → `200 OK`

Response:

```json
{
    "data": [
        {
            "id": 1,
            "judul": "Laskar Pelangi",
            "penulis": "Andrea Hirata",
            "penerbit": "Bentang Pustaka",
            "tahun_terbit": 2005,
            "isbn": "9789793062792",
            "stok": 5,
            "sampul": null,
            "category": {
                "id": 1,
                "nama_kategori": "Fiksi"
            },
            "created_at": "2026-10-27T04:11:16.000000Z",
            "updated_at": "2026-10-27T04:11:16.000000Z"
        }
    ],
    "links": {
        "first": "http://127.0.0.1:8000/api/books?page=1",
        "last": "http://127.0.0.1:8000/api/books?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "page": null,
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/books?page=1",
                "label": "1",
                "page": 1,
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "page": null,
                "active": false
            }
        ],
        "path": "http://127.0.0.1:8000/api/books",
        "per_page": 10,
        "to": 1,
        "total": 1
    }
}
```


**Filter kategori** - `GET /api/books?category_id=2` → `200 OK`

Response:

```json
{
    "data": [
        {
            "id": 2,
            "judul": "Clean Code",
            "penulis": "Robert C. Martin",
            "penerbit": "Prentice Hall",
            "tahun_terbit": 2008,
            "isbn": "9780132350884",
            "stok": 3,
            "sampul": null,
            "category": {
                "id": 2,
                "nama_kategori": "Teknologi"
            },
            "created_at": "2026-10-27T04:11:16.000000Z",
            "updated_at": "2026-10-27T04:11:16.000000Z"
        }
    ],
    "links": {
        "first": "http://127.0.0.1:8000/api/books?page=1",
        "last": "http://127.0.0.1:8000/api/books?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "page": null,
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/books?page=1",
                "label": "1",
                "page": 1,
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "page": null,
                "active": false
            }
        ],
        "path": "http://127.0.0.1:8000/api/books",
        "per_page": 10,
        "to": 1,
        "total": 1
    }
}
```


### 2. GET /api/books/{id}

Detail satu buku beserta kategorinya.

**Sukses** - `GET /api/books/1` → `200 OK`

Response:

```json
{
    "data": {
        "id": 1,
        "judul": "Laskar Pelangi",
        "penulis": "Andrea Hirata",
        "penerbit": "Bentang Pustaka",
        "tahun_terbit": 2005,
        "isbn": "9789793062792",
        "stok": 5,
        "sampul": null,
        "category": {
            "id": 1,
            "nama_kategori": "Fiksi"
        },
        "created_at": "2026-10-27T04:11:16.000000Z",
        "updated_at": "2026-10-27T04:11:16.000000Z"
    }
}
```


**Id tidak ada** - `GET /api/books/999` → `404 Not Found`

Response:

```json
{
    "message": "No query results for model [App\\Models\\Book] 999"
}
```


### 3. POST /api/books

Tambah buku baru. Validasi memakai `StoreBookRequest` yang sama dengan form web.

**Sukses** - `POST /api/books` → `201 Created`

Body:

```json
{
    "judul": "Bumi Manusia",
    "penulis": "Pramoedya Ananta Toer",
    "penerbit": "Hasta Mitra",
    "tahun_terbit": 1980,
    "isbn": "9789794330746",
    "stok": 4,
    "category_id": 1
}
```

Response:

```json
{
    "data": {
        "id": 3,
        "judul": "Bumi Manusia",
        "penulis": "Pramoedya Ananta Toer",
        "penerbit": "Hasta Mitra",
        "tahun_terbit": 1980,
        "isbn": "9789794330746",
        "stok": 4,
        "sampul": null,
        "category": {
            "id": 1,
            "nama_kategori": "Fiksi"
        },
        "created_at": "2026-10-27T04:11:19.000000Z",
        "updated_at": "2026-10-27T04:11:19.000000Z"
    }
}
```


**Body kosong** - `POST /api/books` → `422 Unprocessable Entity`

Body:

```json
{}
```

Response:

```json
{
    "message": "Judul buku wajib diisi. (and 5 more errors)",
    "errors": {
        "judul": [
            "Judul buku wajib diisi."
        ],
        "penulis": [
            "Nama penulis wajib diisi."
        ],
        "penerbit": [
            "Nama penerbit wajib diisi."
        ],
        "tahun_terbit": [
            "Tahun terbit wajib diisi."
        ],
        "stok": [
            "Stok wajib diisi."
        ],
        "category_id": [
            "Kategori wajib dipilih."
        ]
    }
}
```


### 4. PUT /api/books/{id}

Perbarui data buku (validasi inline).

**Sukses** - `PUT /api/books/3` → `200 OK`

Body:

```json
{
    "judul": "Bumi Manusia (Cetakan Baru)",
    "penulis": "Pramoedya Ananta Toer",
    "penerbit": "Lentera Dipantara",
    "tahun_terbit": 2005,
    "isbn": "9789794330746",
    "stok": 6,
    "category_id": 1
}
```

Response:

```json
{
    "data": {
        "id": 3,
        "judul": "Bumi Manusia (Cetakan Baru)",
        "penulis": "Pramoedya Ananta Toer",
        "penerbit": "Lentera Dipantara",
        "tahun_terbit": 2005,
        "isbn": "9789794330746",
        "stok": 6,
        "sampul": null,
        "category": {
            "id": 1,
            "nama_kategori": "Fiksi"
        },
        "created_at": "2026-10-27T04:11:19.000000Z",
        "updated_at": "2026-10-27T04:11:19.000000Z"
    }
}
```


**Data tidak valid** - `PUT /api/books/3` → `422 Unprocessable Entity`

Body:

```json
{
    "judul": "",
    "stok": -1
}
```

Response:

```json
{
    "message": "The judul field is required. (and 5 more errors)",
    "errors": {
        "judul": [
            "The judul field is required."
        ],
        "penulis": [
            "The penulis field is required."
        ],
        "penerbit": [
            "The penerbit field is required."
        ],
        "tahun_terbit": [
            "The tahun terbit field is required."
        ],
        "stok": [
            "The stok field must be at least 0."
        ],
        "category_id": [
            "The category id field is required."
        ]
    }
}
```


### 5. DELETE /api/books/{id}

Hapus buku.

**Sukses** - `DELETE /api/books/3` → `200 OK`

Response:

```json
{
    "message": "Buku berhasil dihapus."
}
```


**Id tidak ada** - `DELETE /api/books/999` → `404 Not Found`

Response:

```json
{
    "message": "No query results for model [App\\Models\\Book] 999"
}
```


### 6. GET /api/members

Daftar anggota (pagination 10 per halaman).

**Sukses** - `GET /api/members` → `200 OK`

Response:

```json
{
    "data": [
        {
            "id": 1,
            "nama": "Siti Aminah",
            "nim": "3125600001",
            "email": "siti@student.pens.ac.id",
            "nomor_telepon": "081234567890",
            "alamat": "Jl. Keputih No. 10, Surabaya",
            "status": "aktif",
            "created_at": "2026-10-27T04:11:16.000000Z",
            "updated_at": "2026-10-27T04:11:16.000000Z"
        }
    ],
    "links": {
        "first": "http://127.0.0.1:8000/api/members?page=1",
        "last": "http://127.0.0.1:8000/api/members?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "page": null,
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/members?page=1",
                "label": "1",
                "page": 1,
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "page": null,
                "active": false
            }
        ],
        "path": "http://127.0.0.1:8000/api/members",
        "per_page": 10,
        "to": 1,
        "total": 1
    }
}
```


### 7. GET /api/members/{id}

Detail satu anggota.

**Sukses** - `GET /api/members/1` → `200 OK`

Response:

```json
{
    "data": {
        "id": 1,
        "nama": "Siti Aminah",
        "nim": "3125600001",
        "email": "siti@student.pens.ac.id",
        "nomor_telepon": "081234567890",
        "alamat": "Jl. Keputih No. 10, Surabaya",
        "status": "aktif",
        "created_at": "2026-10-27T04:11:16.000000Z",
        "updated_at": "2026-10-27T04:11:16.000000Z"
    }
}
```


**Id tidak ada** - `GET /api/members/999` → `404 Not Found`

Response:

```json
{
    "message": "No query results for model [App\\Models\\Member] 999"
}
```


### 8. GET /api/loans

Daftar transaksi peminjaman beserta anggota, petugas, dan buku yang dipinjam.

**Sukses** - `GET /api/loans` → `200 OK`

Response:

```json
{
    "data": [
        {
            "id": 1,
            "member": {
                "id": 1,
                "nama": "Siti Aminah"
            },
            "petugas": {
                "id": 2,
                "name": "Petugas Satu"
            },
            "tanggal_pinjam": "2026-10-27",
            "tanggal_kembali": "2026-11-03",
            "tanggal_dikembalikan": null,
            "status": "dipinjam",
            "books": [
                {
                    "id": 1,
                    "judul": "Laskar Pelangi"
                },
                {
                    "id": 2,
                    "judul": "Clean Code"
                }
            ]
        }
    ],
    "links": {
        "first": "http://127.0.0.1:8000/api/loans?page=1",
        "last": "http://127.0.0.1:8000/api/loans?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "page": null,
                "active": false
            },
            {
                "url": "http://127.0.0.1:8000/api/loans?page=1",
                "label": "1",
                "page": 1,
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "page": null,
                "active": false
            }
        ],
        "path": "http://127.0.0.1:8000/api/loans",
        "per_page": 10,
        "to": 1,
        "total": 1
    }
}
```


### 9. POST /api/loans

Buat transaksi peminjaman. `user_id` (petugas) wajib dikirim karena API tidak memakai session login.

**Sukses** - `POST /api/loans` → `201 Created`

Body:

```json
{
    "member_id": 1,
    "user_id": 2,
    "tanggal_pinjam": "2026-10-27",
    "tanggal_kembali": "2026-11-03",
    "book_ids": [
        1,
        2
    ]
}
```

Response:

```json
{
    "data": {
        "id": 1,
        "member": {
            "id": 1,
            "nama": "Siti Aminah"
        },
        "petugas": {
            "id": 2,
            "name": "Petugas Satu"
        },
        "tanggal_pinjam": "2026-10-27",
        "tanggal_kembali": "2026-11-03",
        "tanggal_dikembalikan": null,
        "status": "dipinjam",
        "books": [
            {
                "id": 1,
                "judul": "Laskar Pelangi"
            },
            {
                "id": 2,
                "judul": "Clean Code"
            }
        ]
    }
}
```


**Data tidak valid** - `POST /api/loans` → `422 Unprocessable Entity`

Body:

```json
{
    "member_id": 1,
    "tanggal_pinjam": "2026-10-27",
    "tanggal_kembali": "2026-10-20"
}
```

Response:

```json
{
    "message": "Petugas (user_id) wajib diisi. (and 2 more errors)",
    "errors": {
        "user_id": [
            "Petugas (user_id) wajib diisi."
        ],
        "tanggal_kembali": [
            "Tanggal kembali tidak boleh sebelum tanggal pinjam."
        ],
        "book_ids": [
            "Pilih minimal satu buku."
        ]
    }
}
```


### 10. PUT /api/loans/{id}/kembalikan

Tandai transaksi sudah dikembalikan: `status` jadi `dikembalikan`, `tanggal_dikembalikan` diisi tanggal hari ini.

**Sukses** - `PUT /api/loans/1/kembalikan` → `200 OK`

Response:

```json
{
    "data": {
        "id": 1,
        "member": {
            "id": 1,
            "nama": "Siti Aminah"
        },
        "petugas": {
            "id": 2,
            "name": "Petugas Satu"
        },
        "tanggal_pinjam": "2026-10-27",
        "tanggal_kembali": "2026-11-03",
        "tanggal_dikembalikan": "2026-10-27",
        "status": "dikembalikan",
        "books": [
            {
                "id": 1,
                "judul": "Laskar Pelangi"
            },
            {
                "id": 2,
                "judul": "Clean Code"
            }
        ]
    }
}
```


**Id tidak ada** - `PUT /api/loans/999/kembalikan` → `404 Not Found`

Response:

```json
{
    "message": "No query results for model [App\\Models\\Loan] 999"
}
```


### 11. GET /api/stats

Ringkasan angka: total buku, total anggota, dan jumlah peminjaman yang masih aktif (`dipinjam`).

**Sebelum pengembalian** - `GET /api/stats` → `200 OK`

Response:

```json
{
    "total_buku": 2,
    "total_anggota": 1,
    "peminjaman_aktif": 1
}
```


**Setelah pengembalian** - `GET /api/stats` → `200 OK`

Response:

```json
{
    "total_buku": 2,
    "total_anggota": 1,
    "peminjaman_aktif": 0
}
```

