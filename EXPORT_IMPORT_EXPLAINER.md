# Penjelasan Detail Mekanisme Export & Import

Dokumen ini menjelaskan bagaimana fitur Export (Laporan) dan Import (Upload Data) bekerja **spesifik pada aplikasi Absensi Baso ini**. Anda bisa menggunakan penjelasan ini untuk presentasi atau dokumentasi teknis.

---

## 1. Fitur Import Data Siswa (Excel)

Fitur ini memungkinkan admin menarik ribuan data siswa dari file Excel dan memasukkannya ke database secara otomatis.

**Lokasi Code:** `app/Livewire/Admin/DataSiswa/Index.php`
**Library:** `phpoffice/phpspreadsheet`

### Bagaimana cara kerjanya? (Alur Logika)

Proses terjadi di dalam fungsi `importExcel()`:

1.  **Upload File**:
    User memilih file Excel. File sementara disimpan oleh Livewire.
    ```php
    $path = $this->importFile->getRealPath();
    ```

2.  **Membaca File**:
    Sistem menggunakan `IOFactory` untuk membuka file Excel tersebut.
    ```php
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile($path);
    $spreadsheet = $reader->load($path);
    $rows = $worksheet->toArray(); // Mengubah Excel jadi Array baris demi baris
    ```

3.  **Looping (Perulangan)**:
    Sistem membaca setiap baris satu per satu. Baris pertama dilewati karena dianggap sebagai "Header/Judul Kolom" (`array_shift($rows)`).

4.  **Cek Otomatis Kelas & Tahun Ajar**:
    Ini bagian pintarnya. Sistem tidak error jika Kelas belum ada. Sistem akan mengecek: "Apakah kelas 'X RPL 1' ada di database?"
    *   Jika **Ada**: Ambil ID-nya.
    *   Jika **Tidak Ada**: Buat baru otomatis (`firstOrCreate`).
    ```php
    // Contoh Logika di code:
    $kelas = Kelas::firstOrCreate(['nama_kelas' => $kelasNama]);
    ```

5.  **Simpan Data Siswa**:
    Sistem menggunakan `updateOrCreate` berdasarkan NIS. Artinya:
    *   Jika NIS sudah ada -> **Update** datanya (cegah duplikat).
    *   Jika NIS belum ada -> **Buat** siswa baru.

---

## 2. Fitur Export Laporan Bulanan (Excel & PDF)

Fitur ini mengambil data absensi yang sudah direkap dan menyajikannya dalam format siap cetak.

**Lokasi Code:** `app/Livewire/Admin/Dashboard.php`
**Class Export:** `app/Exports/MonthlyRecapExport.php`
**Tampilan Laporan:** `resources/views/exports/monthly-recap.blade.php`

### A. Export ke Excel

Prosesnya sangat simpel karena menggunakan library `Maatwebsite Excel`.
```php
return Excel::download(
    new \App\Exports\MonthlyRecapExport($bulan, $tahun, $kelasId), 
    'NamaFile.xlsx'
);
```
**Penjelasan:**
1.  Admin klik tombol Export Excel.
2.  Sistem memanggil class `MonthlyRecapExport`.
3.  Class tersebut mengambil data siswa + absensi dari database.
4.  Data "dilempar" ke tampilan `monthly-recap.blade.php` (tabel HTML biasa).
5.  Library otomatis mengubah tabel HTML tersebut menjadi file Excel `.xlsx`.

### B. Export ke PDF (Landscape)

Untuk PDF, kita butuh perlakuan khusus agar tabel yang lebar bisa muat (A4 Landscape).

**Logika di `Dashboard.php`:**
```php
// 1. Ambil Data (sama seperti Excel)
$export = new \App\Exports\MonthlyRecapExport(...);
$view = $export->view(); // Ambil tampilan HTML-nya

// 2. Render ke PDF
$pdf = Pdf::loadHTML($view->render())
    ->setPaper('a4', 'landscape'); // SETTING KERTAS DISINI

// 3. Download
return response()->streamDownload(function () use ($pdf) {
    echo $pdf->stream();
}, 'Laporan.pdf');
```

**Kunci Tampilan (Blade)**:
Di file `monthly-recap.blade.php`, kita menggunakan trik CSS agar rapi saat dicetak:
*   `page-break-inside: avoid`: Agar baris tabel tidak terpotong di tengah halaman.
*   `width`: Kolom tanggal dibuat kecil (22px) agar 31 hari muat dalam satu baris.

---

## Ringkasan untuk Presentasi

Jika Anda menjelaskan ini ke orang awam/user:

*   **Import**: "Sistem ini cerdas. Bapak/Ibu cukup upload Excel, nanti sistem yang akan otomatis mendeteksi apakah siswanya baru atau lama. Kalau ada Kelas baru di file Excel, sistem otomatis membuatkannya juga."
*   **Export**: "Laporan dibuat sangat fleksibel. Kita bisa mencetaknya ke Excel untuk diedit lagi, atau langsung ke PDF jika ingin laporan resmi yang rapi dan siap tanda tangan. Formatnya sudah otomatis Landscape agar semua tanggal 1-31 terlihat jelas."
