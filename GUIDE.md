# Panduan Lengkap Sistem Informasi Absensi (Absensi Baso)

Dokumen ini berisi panduan lengkap mengenai instalasi, konfigurasi, dan penggunaan sistem absensi berbasis web ini.

---

## 1. Pengenalan Sistem

Sistem ini adalah aplikasi web untuk mencatat dan merekap kehadiran siswa. Aplikasi ini dibangun menggunakan framework **Laravel** dengan antarmuka dinamis menggunakan **Livewire**.

### Fitur Utama
*   **Multi-role**: Administrator dan Guru Piket.
*   **Manajemen Data**: Master data untuk Tahun Ajar, Kelas, dan Siswa.
*   **Pencatatan Absensi**: Input kehadiran harian (Hadir, Sakit, Izin, Alpa) oleh Guru Piket.
*   **Laporan**: Rekapitulasi absensi bulanan dan harian dengan fitur ekspor ke Excel dan PDF.
*   **Dashboard**: Statistik kehadiran real-time.

---

## 2. Persyaratan Sistem (System Requirements)

Untuk menjalankan aplikasi ini di server lokal (localhost), pastikan komputer Anda memiliki perangkat lunak berikut:

*   **PHP**: Versi 8.1 atau lebih baru.
*   **Composer**: Untuk manajemen dependensi PHP.
*   **Node.js & NPM**: Untuk manajemen aset frontend (CSS/JS).
*   **Database**: MySQL atau MariaDB.
*   **Web Server**: Apache atau Nginx (bisa juga menggunakan `php artisan serve`).

---

## 3. Panduan Instalasi (Installation Guide)

Ikuti langkah-langkah berikut untuk menginstall aplikasi di komputer Anda:

1.  **Clone Repository** (atau ekstrak file zip jika diunduh manual):
    ```bash
    git clone https://github.com/daffa102/Absensi-Baso.git
    cd Absensi-Baso
    ```

2.  **Install Dependensi PHP**:
    ```bash
    composer install
    ```

3.  **Install Dependensi Frontend**:
    ```bash
    npm install
    npm run build
    ```

4.  **Konfigurasi Environment**:
    *   Salin file `.env.example` menjadi `.env`:
        ```bash
        cp .env.example .env
        ```
    *   Buka file `.env` dan sesuaikan konfigurasi database:
        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=absensi_baso  # Pastikan nama database ini sesuai
        DB_USERNAME=root          # User database Anda
        DB_PASSWORD=              # Password database Anda
        ```

5.  **Generate Application Key**:
    ```bash
    php artisan key:generate
    ```

6.  **Migrasi Database dan Seeding**:
    Langkah ini akan membuat tabel dan mengisi data awal (akun admin default).
    ```bash
    php artisan migrate:fresh --seed
    ```

7.  **Jalankan Server**:
    ```bash
    php artisan serve
    ```
    Akses aplikasi di `http://127.0.0.1:8000`.

---

## 4. Panduan Pengguna: Administrator

Administrator memiliki akses penuh ke seluruh fitur sistem.

### 4.1 Login Admin
*   Buka halaman login.
*   Gunakan kredensial admin (jika menggunakan seeder default):
    *   Email: `admin@admin.com` (atau cek `DatabaseSeeder.php`)
    *   Password: `password`

### 4.2 Dashboard Admin
Setelah login, Anda akan diarahkan ke Dashboard yang menampilkan:
*   Ringkasan kehadiran hari ini (Hadir, Sakit, Izin, Alpa).
*   Grafik statistik (jika ada).
*   **Fitur Ekspor**:
    *   Pilih Kelas, Bulan, dan Tahun.
    *   Klik tombol **Export Excel** atau **Export PDF** untuk mengunduh rekap absensi bulanan.

### 4.3 Manajemen Data Master
Menu ini digunakan untuk mengatur data referensi.
*   **Data Tahun Ajar**: Menambah atau menonaktifkan tahun ajaran.
*   **Data Kelas**: Menambah kelas baru (misal: X RPL 1, XI TKJ 2).
*   **Data Siswa**:
    *   Mendaftarkan siswa baru secara manual.
    *   **Import Excel**: Mengunggah data siswa banyak sekaligus menggunakan template Excel.

---

## 5. Panduan Pengguna: Guru Piket

Guru Piket bertugas mencatat kehadiran siswa setiap hari.

### 5.1 Login Guru
*   Gunakan akun yang telah didaftarkan oleh admin.

### 5.2 Input Absensi
1.  Masuk ke Dashboard Guru.
2.  **Pilih Kelas** pada menu dropdown di bagian atas.
3.  Daftar siswa kelas tersebut akan muncul.
4.  Secara default data mungkin kosong atau terisi otomatis jika sudah ada input sebelumnya.
5.  Klik status kehadiran untuk setiap siswa:
    *   **H** (Hadir - Hijau)
    *   **S** (Sakit - Kuning)
    *   **I** (Izin - Biru)
    *   **A** (Alpa - Merah)
6.  Klik tombol **Simpan Absensi** di pojok kanan bawah/atas untuk menyimpan perubahan ke database.

---

## 6. Troubleshooting (Pemecahan Masalah)

### Error: "Vite manifest not found"
Solusi: Jalankan perintah `npm run build` di terminal untuk membuild aset frontend.

### Error: Database connection refused
Solusi: Pastikan aplikasi database (MySQL/XAMPP/Laragon) sudah berjalan dan konfigurasi di file `.env` sudah benar.

### Tampilan PDF Berantakan
Solusi: Jika menggunakan fitur Export PDF, pastikan sistem merender layout landscape. Kami telah mengoptimalkan layout untuk A4 Landscape.

---
**Dibuat oleh Tim Pengembang Absensi Baso**
