# Aplikasi Manajemen Surat Digital (E-Office)

<p align="center">
  <img src="[URL_SCREENSHOT_DASHBOARD_ANDA]" alt="Tampilan Dashboard Aplikasi" width="700">
</p>

Aplikasi Manajemen Surat Digital adalah sebuah sistem informasi berbasis web yang modern untuk mengelola, melacak, dan mengarsipkan surat masuk dan surat keluar di dalam sebuah organisasi. Aplikasi ini dibangun dari nol menggunakan **TALL Stack (Tailwind CSS, Alpine.js, Livewire, Laravel)**, menghasilkan antarmuka yang reaktif, cepat, dan responsif.

Tujuan utama dari aplikasi ini adalah untuk menggantikan proses manual (buku agenda) menjadi sistem digital yang efisien, transparan, dan mudah diaudit.

---

## ✨ Fitur Utama

Aplikasi ini dilengkapi dengan berbagai fitur canggih untuk memenuhi kebutuhan manajemen perkantoran modern:

-   **Manajemen Surat Masuk & Keluar:**

    -   CRUD (Create, Read, Update, Delete) penuh untuk kedua jenis surat.
    -   Formulir unggah file _drag-and-drop_ dengan animasi dan _progress bar_.
    -   Pencarian _real-time_ dan paginasi untuk manajemen data yang efisien.

-   **Alur Kerja Disposisi:**

    -   Pimpinan dapat meneruskan surat masuk kepada staf dengan instruksi spesifik.
    -   Staf menerima notifikasi dan dapat melihat daftar disposisi yang ditujukan kepadanya.
    -   Staf dapat memperbarui status disposisi (misalnya, "Selesai").
    -   Riwayat disposisi tercatat rapi di setiap surat.

-   **Dashboard & Pelaporan:**

    -   Dashboard utama dengan kartu statistik (total surat, surat bulan ini, dll).
    -   Grafik interaktif untuk memvisualisasikan tren surat masuk.
    -   Fitur untuk men-generate laporan PDF berdasarkan jenis surat dan rentang tanggal.

-   **Manajemen Pengguna & Keamanan:**

    -   Sistem Peran & Hak Akses (Admin, Pimpinan, Staf) menggunakan `spatie/laravel-permission`.
    -   Proteksi pada halaman dan fitur berdasarkan peran pengguna.
    -   Panel admin khusus untuk mengelola (CRUD) data pengguna dan perannya.

-   **Notifikasi & Audit:**
    -   Notifikasi _real-time_ di dalam aplikasi (ikon lonceng) saat ada disposisi baru.
    -   Notifikasi via email untuk memberitahu pengguna di luar aplikasi.
    -   **Log Aktivitas** yang mencatat semua aksi penting (pembuatan, pembaruan, penghapusan data) untuk keperluan audit.

---

## 🛠️ Teknologi yang Digunakan

-   **Backend:** Laravel 11, PHP 8.2+
-   **Frontend:** Livewire 3, Alpine.js, Tailwind CSS
-   **Database:** MySQL / MariaDB
-   **Package Utama:**
    -   `spatie/laravel-permission` - Untuk manajemen peran & hak akses.
    -   `spatie/laravel-activitylog` - Untuk mencatat log aktivitas.
    -   `barryvdh/laravel-dompdf` - Untuk generate laporan PDF.
    -   `Chart.js` - Untuk menampilkan grafik di dashboard.

---

## 🚀 Instalasi & Setup Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda:

1.  **Clone Repositori**

    ```bash
    git clone [URL_REPOSITORI_ANDA]
    cd [NAMA_FOLDER_PROYEK]
    ```

2.  **Install Dependencies**

    ```bash
    composer install
    npm install
    ```

3.  **Konfigurasi Lingkungan**

    -   Salin file `.env.example` menjadi `.env`.
        ```bash
        cp .env.example .env
        ```
    -   Generate kunci aplikasi.
        ```bash
        php artisan key:generate
        ```
    -   Atur koneksi database (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) dan konfigurasi `MAIL_` di dalam file `.env`.

4.  **Migrasi & Seeding Database**

    -   Jalankan perintah ini untuk membuat semua tabel dan mengisinya dengan data uji (termasuk user, peran, dan surat palsu).
        ```bash
        php artisan migrate:fresh --seed
        ```

5.  **Buat Storage Link**

    -   Perintah ini penting untuk memastikan file yang diunggah dapat diakses publik.
        ```bash
        php artisan storage:link
        ```

6.  **Jalankan Aplikasi**
    -   Jalankan _build tools_ untuk frontend di satu terminal.
        ```bash
        npm run dev
        ```
    -   Jalankan _queue worker_ untuk memproses notifikasi di terminal kedua.
        ```bash
        php artisan queue:work
        ```
    -   Jalankan server pengembangan di terminal ketiga.
        ```bash
        php artisan serve
        ```
    -   Aplikasi sekarang bisa diakses di `http://127.0.0.1:8000`.

---

## 🔐 Akun Demo

Anda bisa login menggunakan akun-akun berikut yang sudah dibuat oleh _seeder_:

-   **Admin:**
    -   **Email:** `admin@example.com`
    -   **Password:** `password`
-   **Pimpinan:**
    -   **Email:** `pimpinan@example.com`
    -   **Password:** `password`
-   **Staf:**
    -   Seeder akan membuat beberapa akun staf dengan email acak. Anda bisa melihatnya di database atau di halaman Kelola Pengguna saat login sebagai Admin.
    -   **Password:** `password`

---

## 🖼️ Tampilan Aplikasi

_Berikut adalah beberapa tampilan dari aplikasi:_

<p align="center">
  <img src="[URL_SCREENSHOT_SURAT_MASUK]" alt="Halaman Surat Masuk" width="45%">
  &nbsp; &nbsp;
  <img src="[URL_SCREENSHOT_DETAIL_SURAT]" alt="Halaman Detail Surat" width="45%">
</p>

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah **MIT License**. Lihat file `LICENSE` untuk detail lebih lanjut.
