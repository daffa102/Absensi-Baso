# Tutorial Lengkap: Membuat Sistem Absensi Baso (Zero to Hero)

Panduan ini ditulis khusus untuk **pemula**. Kita akan membangun aplikasi web Absensi langkah demi langkah, mulai dari layar kosong hingga jadi sistem yang bisa dipakai.

**Apa yang akan kita buat?**
Sebuah aplikasi web untuk sekolah dimana:
1.  **Admin** bisa mengelola data siswa, kelas, dan melihat laporan.
2.  **Guru Piket** bisa melakukan absensi harian (Hadir, Sakit, Izin, Alpa).
3.  **Laporan** bisa didownload dalam format Excel atau PDF.

---

## BAB 1: Persiapan Perang (Instalasi)

Sebelum coding, pastikan alat tempur Anda siap. Buka terminal dan cek versi PHP, Composer, dan Node.js.

### Langkah 1: Buat Project Laravel Baru
```bash
composer create-project laravel/laravel Absensi-Baso
cd Absensi-Baso
```

### Langkah 2: Setup Database
1.  Buat database `absensi_baso` di MySQL.
2.  Edit file `.env` di project Anda:
    ```env
    DB_DATABASE=absensi_baso
    DB_USERNAME=root
    DB_PASSWORD=
    ```

### Langkah 3: Install Livewire & Tailwind
**Install Livewire:**
```bash
composer require livewire/livewire
```

**Install Tailwind CSS:**
```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```
*Jangan lupa konfigurasi `tailwind.config.js` dan `app.css` seperti biasa.*

---

## BAB 2: Membangun Pondasi (Database)

Jalankan perintah ini untuk membuat file migration:
```bash
php artisan make:model TahunAjar -m
php artisan make:model Kelas -m
php artisan make:model Siswa -m
php artisan make:model Absensi -m
```

Isi file migration di `database/migrations/` sesuai kebutuhan (lihat tutorial sebelumnya untuk detail kolom). Lalu jalankan:
```bash
php artisan migrate
```

---

## BAB 3: Fitur Utama (Absensi Guru)

Buat komponen Livewire untuk Guru:
```bash
php artisan make:livewire Guru/Dashboard
```

Isi `app/Livewire/Guru/Dashboard.php` dengan logika simpan absensi (`updateOrCreate`), dan buat tampilan tabel di `resources/views/livewire/guru/dashboard.blade.php`.

---

## BAB 4: Fitur Lanjutan (Export & Import Excel/PDF)

Ini adalah bagian paling diminta: **Bagaimana cara membuat fitur download Laporan?**

Kita akan menggunakan 2 library populer:
1.  `maatwebsite/excel`: Untuk Excel (Import & Export).
2.  `barryvdh/laravel-dompdf`: Untuk PDF.

### 4.1 Instalasi Library
Buka terminal dan jalankan:
```bash
composer require maatwebsite/excel barryvdh/laravel-dompdf
```

### 4.2 Membuat Export Excel (Laporan Bulanan)
Kita ingin admin bisa download rekap absen per bulan.

1.  **Buat Class Export**:
    ```bash
    php artisan make:export MonthlyRecapExport
    ```

2.  **Edit `app/Exports/MonthlyRecapExport.php`**:
    Kita gunakan fitur `FromView` agar desainnya bisa diatur lewat HTML table biasa.

    ```php
    namespace App\Exports;

    use App\Models\Siswa;
    use Illuminate\Contracts\View\View;
    use Maatwebsite\Excel\Concerns\FromView;
    use Maatwebsite\Excel\Concerns\ShouldAutoSize;

    class MonthlyRecapExport implements FromView, ShouldAutoSize
    {
        protected $month;
        protected $year;
        protected $kelasId;

        public function __construct($month, $year, $kelasId) {
            $this->month = $month;
            $this->year = $year;
            $this->kelasId = $kelasId;
        }

        public function view(): View {
            // Ambil siswa di kelas tersebut beserta data absensinya di bulan yg dipilih
            $siswas = Siswa::where('kelas_id', $this->kelasId)
                ->with(['absensis' => function($q) {
                    $q->whereMonth('tanggal', $this->month)
                      ->whereYear('tanggal', $this->year);
                }])->get();

            return view('exports.monthly-recap', [
                'siswas' => $siswas,
                'month' => $this->month,
                'year' => $this->year
            ]);
        }
    }
    ```

3.  **Buat Tampilan Tabel (`resources/views/exports/monthly-recap.blade.php`)**:
    Buat tabel HTML biasa. Table ini yang akan otomatis dikonversi jadi Excel!

### 4.3 Membuat Export PDF
Untuk PDF, caranya mirip tapi tidak butuh class Export khusus jika sederhana. Bisa langsung dari Controller/Livewire.

Di `app/Livewire/Admin/Dashboard.php`:
```php
use Barryvdh\DomPDF\Facade\Pdf;

public function downloadPdf() {
    $data = [
        'siswas' => Siswa::all(),
        // load data lain...
    ];

    $pdf = Pdf::loadView('exports.monthly-recap', $data);
    
    // Set kertas jadi Landscape agar muat banyak kolom
    $pdf->setPaper('a4', 'landscape');

    return response()->streamDownload(function () use ($pdf) {
        echo $pdf->stream();
    }, 'Laporan.pdf');
}
```

### 4.4 Membuat Import Excel (Upload Data Siswa)
Agar admin tidak capek input siswa satu persatu, kita buat fitur upload Excel.

1.  **Buat Class Import**:
    ```bash
    php artisan make:import SiswaImport
    ```

2.  **Edit `app/Imports/SiswaImport.php`**:
    ```php
    namespace App\Imports;

    use App\Models\Siswa;
    use App\Models\Kelas;
    use Maatwebsite\Excel\Concerns\ToModel;
    use Maatwebsite\Excel\Concerns\WithHeadingRow; // Agar baris 1 dianggap header

    class SiswaImport implements ToModel, WithHeadingRow
    {
        public function model(array $row)
        {
            // Cari ID kelas berdasarkan nama kelas di Excel (misal "X RPL 1")
            $kelas = Kelas::where('nama_kelas', $row['kelas'])->first();

            return new Siswa([
                'nis' => $row['nis'],
                'nama' => $row['nama'],
                'kelas_id' => $kelas ? $kelas->id : null,
                // dan seterusnya...
            ]);
        }
    }
    ```

3.  **Panggil di Livewire**:
    Di `app/Livewire/Admin/DataSiswa/Index.php`:
    ```php
    use Maatwebsite\Excel\Facades\Excel;
    use App\Imports\SiswaImport;
    use Livewire\WithFileUploads; // Wajib untuk upload file

    class Index extends Component {
        use WithFileUploads;
        
        public $fileExcel;

        public function import() {
            $this->validate(['fileExcel' => 'required|mimes:xlsx,xls']);
            
            Excel::import(new SiswaImport, $this->fileExcel);
            
            session()->flash('success', 'Data siswa berhasil diimport!');
        }
    }
    ```

---

## BAB 5: Menjalankan Aplikasi

Jalankan server:
```bash
php artisan serve
```
Dan jalankan Vite untuk CSS:
```bash
npm run dev
```

Selamat! Anda kini memiliki sistem absensi lengkap dengan fitur Export/Import canggih.
