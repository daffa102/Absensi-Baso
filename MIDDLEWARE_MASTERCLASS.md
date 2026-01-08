# MASTERCLASS: Middleware (Satpam Aplikasi)

Panduan ini membahas **Middleware**, fitur keamanan paling dasar di Laravel. Kita akan membedah bagaimana aplikasi ini membedakan antara **Admin** dan **Guru**.

---

## 1. Apa itu Middleware?
Bayangkan Middleware sebagai **Satpam di Pintu Gerbang**.
Setiap kali ada yang mau masuk ke halaman web (`/admin/dashboard` atau `/guru/dashboard`), mereka harus melewati pos satpam dulu.

Satpam akan mengecek:
*   "Apakah kamu sudah Login?"
*   "Apakah ID Card kamu tulisannya 'Admin'?"

Jika lolos, boleh masuk. Jika tidak, ditendang keluar (Redirect).

---

## 2. Membuat Middleware (Langkah Demi Langkah)

Di projek ini, kita membuat satpam khusus bernama `RoleMiddleware`.

### Langkah 2.1: Buat Filenya
Jalankan perintah di terminal:
```bash
php artisan make:middleware RoleMiddleware
```
File baru akan muncul di `app/Http/Middleware/RoleMiddleware.php`.

### Langkah 2.2: Isi Logika Pengecekan
Di file tersebut, kita tulis aturan mainnya:

```php
public function handle(Request $request, Closure $next, string $role): Response
{
    // 1. Cek apakah user ada? (Sudah login?)
    // 2. Cek apakah role user SAMA dengan role yang diminta?
    if ($request->user() && $request->user()->role !== $role) {
        
        // Kalau beda, tendang ke halaman home (atau login)
        return redirect('/'); 
    }

    // Kalau cocok, silakan lanjut (Buka Pintu)
    return $next($request);
}
```

### Langkah 2.3: Daftarkan "Nama Panggilan" (Alias)
Agar mudah dipanggil di kode, kita beri nama panggilan `role`.
Buka file `bootstrap/app.php` (Laravel 11+).

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->alias([
        // Kita namakan 'role' untuk memanggil RoleMiddleware
        'role' => \App\Http\Middleware\RoleMiddleware::class,
    ]);
})
```

---

## 3. Cara Memasang Middleware (Di Routes)

Sekarang satpam sudah siap dan punya nama. Kita tinggal tugaskan dia menjaga pintu tertentu di `routes/web.php`.

### Kasus: Menjaga Halaman Admin
Kita ingin halaman `/admin/*` cuma bisa dibuka oleh user dengan role `admin`.

```php
// Perhatikan bagian 'role:admin'
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    
    // Semua route di sini DIJAGA KETAT
    Route::get('/dashboard', AdminDashboard::class);
    Route::get('/data-siswa', SiswaIndex::class);
    
});
```
**Artinya**: "Hei sistem, pastikan user sudah login (`auth`) DAN user tersebut punya role `admin` (`role:admin`). Kalau tidak memenuhi syarat, jangan kasih masuk."

### Kasus: Menjaga Halaman Guru
Sama, tapi kodenya beda sedikit.

```php
// Perhatikan bagian 'role:guru_piket'
Route::middleware(['auth', 'role:guru_piket'])->prefix('guru')->group(function () {
    
    Route::get('/dashboard', GuruDashboard::class);
    
});
```

---

## 4. Cheat Sheet (Ringkasan)

1.  **Bikin**: `php artisan make:middleware NamaMiddleware`.
2.  **Logic**: Edit function `handle` untuk cek syarat (if condition). `return $next($request)` kalau lolos, `redirect` kalau gagal.
3.  **Daftar**: Tambahkan ke `bootstrap/app.php` bagian `alias`.
4.  **Pasang**: Pakai `Route::middleware(['nama_alias:parameter'])` di `web.php`.

Selesai! Sekarang aplikasi Anda aman dari penyusup yang salah kamar.
