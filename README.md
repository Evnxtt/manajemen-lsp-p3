# LSP P3 Ekologika - Manajemen Sertifikasi

Aplikasi web berbasis PHP dan MongoDB untuk manajemen proses sertifikasi profesi di bidang ekologi. Aplikasi ini ditujukan untuk Lembaga Sertifikasi Profesi (LSP) Pihak Ketiga (P3) Ekologika.

## Deskripsi

Sistem ini mengelola seluruh alur kerja sertifikasi, mulai dari pendaftaran peserta, manajemen pelatihan, verifikasi pembayaran, hingga penerbitan sertifikat. Aplikasi ini memiliki tiga level pengguna: Peserta (User), Admin, dan Super Admin, masing-masing dengan dasbor dan hak akses yang berbeda.

## Fitur Utama

### Untuk Peserta (User)
- **Pendaftaran & Autentikasi**: Pengguna dapat membuat akun dan masuk ke sistem.
- **Dasbor Pengguna**: Melihat ringkasan status dan berita terbaru.
- **Manajemen Pelatihan**: Mendaftar pelatihan yang tersedia, melihat pelatihan yang diikuti, dan mengunduh modul.
- **Proses Sertifikasi**: Mengisi formulir pendaftaran, mengunggah bukti pembayaran.
- **Pengecekan Status**: Memantau status verifikasi pembayaran dan kelulusan.
- **Unduh Sertifikat**: Mengunduh sertifikat kelulusan dalam format PDF.

### Untuk Admin
- **Manajemen Pengguna**: Mengaktivasi dan menonaktifkan akun peserta.
- **Manajemen Konten**: Mengelola berita dan informasi pelatihan.
- **Manajemen Pelatihan**: Menambah, mengubah, dan menghapus data pelatihan.
- **Verifikasi**: Memverifikasi pembayaran yang diunggah oleh peserta.
- **Melihat Pendaftar**: Melihat daftar peserta yang mendaftar untuk setiap pelatihan.

### Untuk Super Admin
- **Semua Fitur Admin**: Memiliki semua hak akses yang dimiliki oleh Admin.
- **Manajemen Admin**: Menambah dan mengelola akun Admin.
- **Manajemen Semua Akun**: Melihat dan mengelola semua akun yang terdaftar di sistem (Peserta dan Admin).

## Struktur Proyek

```
.
├── index.php             # Halaman utama (landing page)
├── connection.php        # Konfigurasi koneksi ke database MongoDB
├── composer.json         # Daftar dependensi PHP (dikelola dengan Composer)
├── pages/
│   ├── auth/             # Skrip untuk login, logout, register
│   ├── user/             # Halaman dan fungsionalitas untuk peserta
│   ├── admin/            # Halaman dan fungsionalitas untuk admin
│   └── super_admin/      # Halaman dan fungsionalitas untuk super admin
├── assets/               # Aset frontend (CSS, JS, gambar) untuk landing page
├── vendor/               # Dependensi PHP yang di-install oleh Composer
└── ...
```

## Teknologi yang Digunakan

- **Backend**: PHP 8.x
- **Database**: MongoDB
- **Frontend**: HTML, JavaScript, CSS, Bootstrap
- **Template Dasbor**: Skydash
- **Server**: XAMPP (Apache)

## Prasyarat

- Web Server (direkomendasikan XAMPP)
- PHP 8.x dengan ekstensi MongoDB
- Composer
- MongoDB Server

## Instalasi & Konfigurasi

1.  **Clone Repositori**
    ```bash
    git clone https://github.com/username/manajemen-lsp-p3.git
    cd manajemen-lsp-p3
    ```

2.  **Install Dependensi PHP**
    Pastikan Composer terinstall, lalu jalankan perintah berikut di direktori root proyek:
    ```bash
    composer install
    ```

3.  **Setup Database**
    - Pastikan layanan MongoDB Anda berjalan.
    - Buat sebuah database baru di MongoDB dengan nama `lsp_p3`.
    - Di dalam database `lsp_p3`, buat sebuah collection bernama `users`.

4.  **Konfigurasi Koneksi**
    - Buka file `connection.php` dan pastikan URI koneksi sudah benar (default: `mongodb://localhost:27017`).
    - Buka file `pages/auth/login.php` dan `pages/auth/register.php` untuk memastikan nama database dan collection sesuai (`$client->lsp_p3->users`).

5.  **Jalankan Aplikasi**
    - Letakkan folder proyek di dalam direktori `htdocs` pada instalasi XAMPP Anda.
    - Buka XAMPP Control Panel dan start service Apache dan MongoDB.
    - Buka browser dan akses `http://localhost/manajemen-lsp-p3`.

## Akun Default

Untuk masuk pertama kali, Anda perlu membuat akun melalui halaman registrasi. Akun pertama yang dibuat bisa dijadikan Super Admin dengan mengubah rolenya langsung di database MongoDB.

- Buka collection `users` di database `lsp_p3`.
- Cari user yang baru Anda daftarkan.
- Ubah nilai field `role` dari `user` menjadi `super_admin`.
```