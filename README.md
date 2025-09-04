# Sistem Portofolio Siswa - SMK-IT As-Syifa Boarding School

Sistem Portofolio Siswa adalah sebuah platform web yang dirancang khusus untuk siswa SMK-IT As-Syifa Boarding School. Aplikasi ini memungkinkan siswa dari jurusan RPL (Rekayasa Perangkat Lunak) dan DKV (Desain Komunikasi Visual) untuk mengunggah, mengelola, dan memamerkan karya-karya terbaik mereka.

Platform ini juga dilengkapi dengan sistem review oleh guru, di mana setiap karya akan melalui proses kurasi sebelum dipublikasikan di galeri umum, memastikan kualitas portofolio yang ditampilkan.

---

## Fitur Utama

### 👤 Untuk Siswa
- **Dashboard Pribadi:** Halaman utama untuk melihat dan mengelola semua proyek.
- **Manajemen Proyek (CRUD):** Membuat, membaca, memperbarui, dan menghapus draf proyek.
- **Upload Media:** Mendukung unggahan multi-gambar, video (upload file & embed YouTube/Vimeo), dan tautan relevan (GitHub, demo live, Figma, file mentah).
- **Sistem Kategori & Tag:** Memberi label pada setiap proyek dengan teknologi atau kategori yang relevan untuk mempermudah pencarian.
- **Sistem Review:** Mengajukan proyek yang sudah selesai untuk direview oleh guru.
- **Fitur Komentar/Feedback:** Berdiskusi dan menerima masukan dari guru langsung di halaman edit proyek.
- **Pratinjau Proyek:** Melihat tampilan proyek persis seperti yang akan dilihat oleh publik sebelum diajukan.

### 🧑‍🏫 Untuk Guru & Admin
- **Dashboard Review:** Halaman khusus untuk melihat semua proyek yang menunggu persetujuan.
- **Alur Persetujuan:** Menyetujui (publish) atau menolak (reject) proyek siswa dengan memberikan alasan.
- **Fitur Komentar Internal:** Memberikan feedback yang konstruktif kepada siswa selama proses review.
- **Manajemen Pengguna (Admin):** Admin dapat membuat, mengedit, dan menghapus akun untuk semua peran (admin, guru, siswa).

### 🌐 Untuk Publik
- **Galeri Portofolio:** Menampilkan semua proyek yang telah disetujui dalam tata letak yang menarik.
- **Pencarian & Filter Canggih:**
    - Pencarian berdasarkan judul proyek atau nama siswa.
    - Filter berdasarkan jurusan (RPL/DKV).
    - Filter multi-tag ala Mangadex (include/exclude) yang dikelompokkan berdasarkan kategori dan bisa disembunyikan.
- **Halaman Detail Proyek:** Tampilan modern dua kolom dengan informasi proyek yang *sticky* dan galeri media yang imersif (termasuk lightbox).
- **Halaman Profil Publik Siswa:** Setiap siswa memiliki halaman profil sendiri yang menampilkan semua karya yang telah mereka publikasikan.

---

## Teknologi yang Digunakan

- **Backend:** Laravel 11
- **Frontend:** Blade, Tailwind CSS, Alpine.js
- **Database:** MySQL
- **Development Environment:** Laragon
- **Build Tool:** Vite

---

## Panduan Instalasi Lokal

Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan pengembangan lokal.

### Prasyarat
- PHP 8.2+
- Composer
- Node.js & NPM
- Database Server (misalnya, MySQL di dalam Laragon)

### Langkah-langkah Instalasi
1.  **Clone repositori ini.**
2.  **Masuk ke direktori proyek.**
3.  **Install dependensi PHP & JavaScript:**
    ```bash
    composer install
    npm install
    ```
4.  **Salin file environment & generate kunci:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```
5.  **Konfigurasi Database di `.env`:**
    - Buat database baru (misalnya, `smkit_portofolio`).
    - Atur variabel `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD`.
6.  **Jalankan migrasi dan seeder:**
    Perintah ini akan membuat semua tabel dan mengisinya dengan data awal (akun admin, guru, siswa, kategori, dan tag).
    ```bash
    php artisan migrate:fresh --seed
    ```
7.  **Hubungkan folder storage:**
    ```bash
    php artisan storage:link
    ```
8.  **Jalankan server pengembangan:**
    ```bash
    npm run dev
    ```
9.  **Akses aplikasi:**
    Buka `http://nama-proyek.test` (jika menggunakan Laragon) atau `http://127.0.0.1:8000` (jika menggunakan `php artisan serve`).

---

## Akun Default

Setelah menjalankan `php artisan migrate:fresh --seed`, Anda dapat menggunakan akun berikut untuk login:

-   **Admin:**
    -   Email: `admin@example.com`
-   **Guru RPL:**
    -   Email: `guru-rpl@example.com`
-   **Guru DKV:**
    -   Email: `guru-dkv@example.com`
-   **Siswa:**
    -   Seeder akan membuat 20 akun siswa acak (10 RPL, 10 DKV). Anda bisa melihat email mereka langsung di database pada tabel `users`.
-   **Password Universal:**
    -   Password untuk **semua** akun di atas adalah: `password`

---

## Panduan Deployment ke Hosting

Berikut adalah panduan umum untuk men-deploy aplikasi Laravel ini ke *shared hosting* (cPanel) atau VPS.

### 1. Persiapan Server
- Pastikan server Anda memenuhi persyaratan Laravel (PHP 8.2+, ekstensi yang diperlukan seperti Mbstring, DOM, Ctype, dll).
- Anda memiliki akses SSH (untuk VPS) atau File Manager & Terminal (untuk cPanel).

### 2. Unggah Proyek
- Unggah semua file proyek Anda (kecuali folder `node_modules` dan `vendor`) ke direktori root Anda (misalnya `~/public_html` atau direktori domain Anda).
- **Penting:** Pastikan file yang diawali dengan titik (seperti `.env.example`, `.editorconfig`) juga ikut terunggah.

### 3. Konfigurasi Produksi
- **Install Dependensi:** Masuk via SSH/Terminal dan jalankan:
  ```bash
  composer install --optimize-autoloader --no-dev
  npm install
  npm run build

  - **Buat File `.env`:** Salin `.env.example` menjadi `.env`.
    ```bash
    cp .env.example .env
    ```
  - **Edit File `.env` untuk Produksi:**
      - `APP_ENV=production`
      - `APP_DEBUG=false`
      - `APP_URL=https://domain-anda.com`
      - Isi detail koneksi **database produksi** Anda.
      - Jalankan `php artisan key:generate` untuk membuat kunci aplikasi yang aman.

### 4\. Setup Database & Storage

  - Impor database Anda atau jalankan migrasi & seeder jika ini adalah instalasi baru:
    ```bash
    php artisan migrate --seed --force
    ```
  - Buat *symbolic link* agar file di `storage` bisa diakses publik:
    ```bash
    php artisan storage:link
    ```

### 5\. Optimasi

Jalankan perintah ini untuk membuat *cache* dari konfigurasi, rute, dan *view* untuk performa yang lebih cepat.

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 6\. Arahkan Document Root (Paling Penting)

  - **Shared Hosting (cPanel):** Di pengaturan domain Anda, ubah "Document Root" dari `public_html` menjadi `public_html/public`.
  - **VPS (Nginx/Apache):** Konfigurasi *virtual host* Anda agar `root` atau `DocumentRoot` menunjuk ke direktori `/public` dari proyek Anda.

Ini adalah langkah keamanan krusial untuk mencegah akses langsung ke file sensitif seperti `.env`.
