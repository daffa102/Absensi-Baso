<!DOCTYPE html>
<html>
<head>
    <title>Laporan Absensi - {{ $tanggal }}</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .summary { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Absensi Siswa</h2>
        <p>Tanggal: {{ $tanggal }}</p>
    </div>

    <div class="summary">
        <h4>Ringkasan:</h4>
        <ul>
            <li>Hadir: {{ $stats['hadir'] }}</li>
            <li>Sakit: {{ $stats['sakit'] }}</li>
            <li>Izin: {{ $stats['izin'] }}</li>
            <li>Alpa: {{ $stats['alpa'] }}</li>
        </ul>
    </div>

    <h3>Daftar Siswa Tidak Hadir (Alpa/Sakit/Izin):</h3>
    <table>
        <thead>
            <tr>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($absents as $item)
            <tr>
                <td>{{ $item->siswa->nis }}</td>
                <td>{{ $item->siswa->nama }}</td>
                <td>{{ $item->siswa->kelas->nama_kelas }}</td>
                <td>{{ $item->status }}</td>
            </tr>
            @endforeach
            @if($absents->isEmpty())
            <tr>
                <td colspan="4" style="text-align: center;">Tidak ada data.</td>
            </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
