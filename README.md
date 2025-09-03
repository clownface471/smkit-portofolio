# Website Portofolio Siswa - SMK-IT As-Syifa Boarding School

Aplikasi web ini berfungsi sebagai platform digital untuk menampilkan karya-karya (portofolio) dari siswa SMK-IT As-Syifa. Aplikasi ini memiliki dua sisi: halaman publik untuk galeri karya, dan area internal dengan sistem hak akses (role-based) untuk Siswa, Guru, dan Admin.

---

## 1. Arsitektur & Teknologi

-   **Framework:** Laravel 11
-   **Database:** MySQL
-   **Frontend:** Blade Templates dengan komponen, Tailwind CSS untuk styling.
-   **Interactivity:** Alpine.js (untuk modal, form dinamis, dan lightbox).
-   **Asset Bundling:** Vite.
-   **Autentikasi:** Laravel Breeze (starter kit), dimodifikasi untuk menonaktifkan registrasi publik.
-   **Server Lokal (Rekomendasi):** Laragon

## 2. Konsep Kunci & Alur Kerja

-   **Sistem Peran (Roles):** Aplikasi menggunakan tiga peran utama (`siswa`, `guru`, `admin`) yang disimpan di kolom `role` pada tabel `users`. Hak akses dikontrol menggunakan *middleware* `EnsureUserHasRole`.
-   **Pemisahan Jurusan:** Siswa dibedakan berdasarkan `jurusan` (`RPL` atau `DKV`). Jurusan ini mengontrol tampilan dan aturan validasi pada form tambah/edit proyek secara dinamis.
-   **Alur Proyek:** Proyek memiliki `status` yang mengontrol alur kerjanya:
    1.  `draft`: Dibuat/diedit oleh siswa.
    2.  `pending_review`: Diajukan ke guru untuk diperiksa.
    3.  `published`: Disetujui oleh guru dan tampil di halaman publik.
-   **Penyimpanan File:** Semua file yang diunggah (gambar/video) disimpan di `storage/app/public`. Perintah `php artisan storage:link` **wajib** dijalankan agar file-file ini bisa diakses dari web.
-   **Registrasi Terkunci:** Pendaftaran akun baru hanya bisa dilakukan oleh admin melalui panel `/admin/users` untuk menjaga keamanan data.

---

## 3. Instalasi & Setup Lokal

Pastikan Anda memiliki Laragon (atau server lokal sejenis), Composer, dan Node.js/NPM yang sudah terpasang.

### 3.1. Clone Repository

```bash
git clone [https://github.com/clownface471/smkit-portofolio](https://github.com/clownface471/smkit-portofolio) smk-assyifa-portfolio
cd smk-assyifa-portfolio
````

### 3.2. Siapkan Environment File

Salin file `.env.example`, lalu install dependensi PHP (Composer) dan JavaScript (NPM).

```bash
cp .env.example .env
composer install
npm install
```

### 3.3. Konfigurasi `.env`

Buka file `.env` dan atur koneksi database Anda.

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=assyifa_portfolio
DB_USERNAME=root
DB_PASSWORD=
```

**Penting:** Pastikan Anda sudah membuat database kosong bernama `assyifa_portfolio` melalui HeidiSQL atau manajer database lainnya.

### 3.4. Jalankan Perintah Setup Laravel

Buat kunci aplikasi, jalankan migrasi untuk membuat semua tabel, dan buat *symbolic link* untuk penyimpanan file.

```bash
php artisan key:generate
php artisan migrate
php artisan storage:link
```

### 3.5. Compile Aset Frontend

Jalankan Vite development server. Biarkan terminal ini tetap berjalan saat Anda mengembangkan.

```bash
npm run dev
```

### 3.6. Buat Akun Admin Pertama

Gunakan `tinker` untuk membuat akun admin pertama Anda.

```bash
php artisan tinker
```

Di dalam *tinker*, jalankan kode ini:

```php
\App\Models\User::create([
    'name' => 'Admin Sekolah',
    'email' => 'admin@assyifa.sch.id',
    'password' => bcrypt('password'), // Ganti 'password' dengan password yang aman
    'role' => 'admin',
    'email_verified_at' => now(),
]);
```

Ketik `exit` untuk keluar dari *tinker*.

### 3.7. Selesai\!

Akses aplikasi melalui URL lokal Anda (misal: `http://smk-assyifa-portfolio.test`). Login dengan akun admin yang baru saja dibuat.

-----

## 4\. Panduan Deployment (Publikasi ke Server)

Langkah-langkah ini untuk mempublikasikan aplikasi ke server *hosting* yang mendukung PHP & MySQL.

### 4.1. Unggah Kode

Gunakan `git` untuk men-clone *repository* Anda ke direktori server (misal: `/var/www/assyifa-portfolio`).

### 4.2. Install Dependensi (Mode Produksi)

```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### 4.3. Konfigurasi `.env` Produksi

Salin `cp .env.example .env` dan edit file `.env`. Pastikan Anda mengatur:

  - `APP_ENV=production`
  - `APP_DEBUG=false`
  - `APP_URL=https://domain-anda.com`
  - Detail koneksi database produksi Anda.

### 4.4. Jalankan Perintah Produksi

Perintah ini akan mengoptimalkan aplikasi Anda untuk performa dan keamanan.

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force
php artisan storage:link
```

### 4.5. Konfigurasi Web Server

Arahkan *document root* dari domain Anda ke direktori `/public` di dalam folder proyek. Ini adalah langkah keamanan yang sangat penting.

### 4.6. Atur Hak Akses Folder

Pastikan web server (misalnya `www-data`) memiliki izin untuk menulis ke folder `storage` dan `bootstrap/cache`.

```bash
sudo chown -R www-data:www-data /var/www/assyifa-portfolio/storage
sudo chown -R www-data:www-data /var/www/assyifa-portfolio/bootstrap/cache
```

-----

## 5\. Potensi Pengembangan Selanjutnya

  - **Form Multi-Step:** Mengubah form tambah/edit proyek menjadi beberapa langkah.
  - **Fitur Filter Canggih:** Mengaktifkan filter di halaman galeri publik.
  - **Notifikasi Email:** Mengirim notifikasi kepada siswa saat proyek disetujui/ditolak.
  - **Halaman Profil Publik Siswa:** Membangun halaman khusus untuk setiap siswa.

