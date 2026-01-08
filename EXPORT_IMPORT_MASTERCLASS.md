# MASTERCLASS: Fitur Export & Import Data (Langkah demi Langkah)

Panduan ini dibuat **sangat detail** untuk Anda yang ingin memahami cara membuat fitur Export (Laporan ke PDF/Excel) dan Import (Upload Excel) dari nol sampai jadi, persis seperti yang digunakan di aplikasi Absensi Baso ini.

---

## 1. Instalasi Library (Wajib)

Pertama, kita butuh "senjata" tambahan. Kita tidak perlu membuat kode pembaca Excel dari nol. Kita pakai library orang lain yang sudah canggih.

Buka Terminal (CMD/PowerShell) di folder project Anda, lalu ketik perintah ini:

```bash
composer require maatwebsite/excel barryvdh/laravel-dompdf
```

*   `maatwebsite/excel`: Untuk urusan baca/tulis file Excel.
*   `barryvdh/laravel-dompdf`: Untuk mengubah tampilan HTML menjadi file PDF.

*Tunggu sampai selesai...*

---

## 2. Membuat Fitur Export Laporan (Excel & PDF)

Tujuannya: Kita ingin admin bisa pilih kelas dan bulan, lalu klik tombol download, dan keluar file Laporan Absensi.

**Konsep Dasar:**
Kita akan membuat "Tampilan" (View) HTML biasa (tabel), lalu library akan mengubah tampilan itu jadi Excel atau PDF.

### Langkah 2.1: Buat Tampilan Tabelnya
Buat file baru di `resources/views/exports/monthly-recap.blade.php`.
Isinya adalah tabel HTML biasa.

```html
<!-- Kunci agar PDF rapi: CSS didalam file -->
<table>
    <thead>
        <tr>
            <!-- Judul Laporan -->
            <th colspan="37" style="text-align: center; font-weight: bold;">
                LAPORAN REKAP ABSENSI
            </th>
        </tr>
        <tr>
            <th>NO</th>
            <th>NAMA SISWA</th>
            <!-- Loop tanggal 1-31 -->
            @for ($i = 1; $i <= 31; $i++)
                <th>{{ $i }}</th>
            @endfor
            <th>Total Hadir</th>
            <!-- dst... -->
        </tr>
    </thead>
    <tbody>
        @foreach($siswas as $siswa)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $siswa->nama }}</td>
            <!-- Loop Logic Absensi -->
            @for ($d = 1; $d <= 31; $d++)
                <td>
                    <!-- Logika PHP untuk cek status harian -->
                </td>
            @endfor
            <td>{{ $totalHadir }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
```

### Langkah 2.2: Buat "Otak" Export (Export Class)
Kita butuh File Class khusus untuk menangani Excel.
Jalankan:
```bash
php artisan make:export MonthlyRecapExport
```
Buka file `app/Exports/MonthlyRecapExport.php` dan edit jadi begini:

```php
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class MonthlyRecapExport implements FromView, ShouldAutoSize
{
    // Terima data Bulan, Tahun, Kelas dari Controller
    public function __construct($month, $year, $kelasId) {
        $this->month = $month;
        $this->year = $year;
        $this->kelasId = $kelasId;
    }

    // Fungsi Utama: Tentukan View mana yang mau dijadikan Excel
    public function view(): View {
        return view('exports.monthly-recap', [
            // Kirim data siswa ke View
            'siswas' => Siswa::where('kelas_id', $this->kelasId)->get()
        ]);
    }
}
```

### Langkah 2.3: Pasang di Tombol Download (Controller/Livewire)
Di halaman Admin (`app/Livewire/Admin/Dashboard.php`), kita buat fungsi untuk tombol download.

**Untuk Excel:**
```php
public function exportExcel() {
    // Panggil Class Export tadi
    return Excel::download(
        new MonthlyRecapExport($this->bulan, $this->tahun, $this->kelas), 
        'Laporan.xlsx'
    );
}
```

**Untuk PDF:**
Code PDF sedikit beda, kita render manual agar bisa **Landscape**.
```php
public function exportPdf() {
    // 1. Ambil isi HTML dari Class Export
    $export = new MonthlyRecapExport($this->bulan, $this->tahun, $this->kelas);
    $html = $export->view()->render();

    // 2. Load ke DomPDF
    $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape');

    // 3. Download
    return response()->streamDownload(function() use ($pdf) {
        echo $pdf->stream();
    }, 'Laporan.pdf');
}
```

---

## 3. Membuat Fitur Import Data (Upload Excel)

Tujuannya: Admin upload file Excel berisi 100 siswa, sistem otomatis memasukkan mereka ke database tanpa ketik ulang.

### Langkah 3.1: Buat Form Upload
Di file view admin (`resources/views/livewire/admin/data-siswa/index.blade.php`), tambahkan input file.

```html
<form wire:submit="importExcel">
    <input type="file" wire:model="importFile">
    <button type="submit">Upload & Import</button>
</form>
```

### Langkah 3.2: Logika Import "Cerdas" (Manual)
Di file Livewire (`app/Livewire/Admin/DataSiswa/Index.php`), kita buat fungsi `importExcel`.

Kita pakai cara **Manual** agar bisa melakukan logika kompleks seperti cek kelas otomatis.

```php
use Livewire\WithFileUploads;
use PhpOffice\PhpSpreadsheet\IOFactory;

public function importExcel() {
    // 1. Baca File Excel yang diupload
    $path = $this->importFile->getRealPath();
    $spreadsheet = IOFactory::load($path);
    $rows = $spreadsheet->getActiveSheet()->toArray();

    // 2. Loop setiap baris (mulai baris 2 karena baris 1 itu Judul)
    foreach ($rows as $index => $row) {
        if ($index == 0) continue; // Skip judul

        // Ambil kolom excel
        $nis = $row[0];
        $nama = $row[1];
        $namaKelas = $row[2];

        // LOGIKA CERDAS:
        // Cek dulu, kelasnya ada gak di database? Kalau gak ada, buat baru!
        $kelas = Kelas::firstOrCreate(['nama_kelas' => $namaKelas]);

        // Simpan Siswa
        Siswa::updateOrCreate(
            ['nis' => $nis], // Kunci unik (agar tidak dobel)
            [
                'nama' => $nama,
                'kelas_id' => $kelas->id
            ]
        );
    }

    session()->flash('success', 'Selesai! Data berhasil masuk.');
}
```

---

---

## 4. Pelengkap: Download Template Excel

Agar user tidak bingung format Excelnya harus seperti apa, kita sediakan tombol **"Download Template"**.

### Langkah 4.1: Buat Export Khusus Template
Jalankan: `php artisan make:export SiswaTemplateExport`.
Edit file `app/Exports/SiswaTemplateExport.php`:

```php
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SiswaTemplateExport implements FromArray, WithHeadings
{
    // Isi data dummy sebagai contoh
    public function array(): array
    {
        return [
            ['2024001', 'Contoh Nama Siswa', 'XII RPL 1'],
        ];
    }

    // Judul Kolom (Wajib sama dengan logika Import)
    public function headings(): array
    {
        return ['NIS', 'Nama', 'Kelas'];
    }
}
```

### Langkah 4.2: Pasang di Tombol (Livewire)
Di `app/Livewire/Admin/DataSiswa/Index.php`:

```php
public function downloadTemplate()
{
    return Excel::download(
        new \App\Exports\SiswaTemplateExport, 
        'template_siswa.xlsx'
    );
}
```
Lalu di view blade tinggal panggil `wire:click="downloadTemplate"`.

---

## Ringkasan Singkat (Cheat Sheet)

1.  **Install**: `composer require maatwebsite/excel barryvdh/laravel-dompdf`
2.  **Export Excel**: Buat class Export (`make:export`), panggil `Excel::download(new ExportClass)`.
3.  **Export PDF**: Ambil view HTML, panggil `Pdf::loadHTML()->setPaper()->stream()`.
4.  **Import Excel**: Upload file, baca pakai `IOFactory::load()`, loop barisnya, simpan pakai `Model::create`.

Itulah cara membuat fitur Export Import dari awal sampai akhir!
