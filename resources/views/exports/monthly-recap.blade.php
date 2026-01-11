<table>
    <thead>
        <tr>
            <th colspan="37" style="text-align: center; font-weight: bold; font-size: 14pt;">
                LAPORAN REKAP ABSENSI KELAS {{ $kelas->nama_kelas }}
            </th>
            <style>
                tr { page-break-inside: avoid; }
                td, th { vertical-align: middle; padding: 2px; }
                table { width: 100%; border-collapse: collapse; font-size: 10pt; }
            </style>
        </tr>
        <tr>
            <th colspan="37" style="text-align: center; font-weight: bold; font-size: 12pt;">
                BULAN: {{ strtoupper(\Carbon\Carbon::create(null, $month, 1)->translatedFormat('F Y')) }}
            </th>
        </tr>
        <tr>
            <th rowspan="2" style="border: 1px solid black; font-weight: bold; text-align: center; vertical-align: middle; width: 30px;">NO</th>
            <th rowspan="2" style="border: 1px solid black; font-weight: bold; text-align: center; vertical-align: middle; width: 200px;">NAMA SISWA</th>
            <th colspan="31" style="border: 1px solid black; font-weight: bold; text-align: center;">TANGGAL</th>
            <th colspan="4" style="border: 1px solid black; font-weight: bold; text-align: center;">TOTAL</th>
        </tr>
        <tr>
            @for ($i = 1; $i <= 31; $i++)
                <th style="border: 1px solid black; text-align: center; width: 22px;">{{ $i }}</th>
            @endfor
            <th style="border: 1px solid black; text-align: center; width: 30px;">H</th>
            <th style="border: 1px solid black; text-align: center; width: 30px;">S</th>
            <th style="border: 1px solid black; text-align: center; width: 30px;">I</th>
            <th style="border: 1px solid black; text-align: center; width: 30px;">A</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($siswas as $index => $siswa)
            <tr>
                <td style="border: 1px solid black; text-align: center;">{{ $index + 1 }}</td>
                <td style="border: 1px solid black;">{{ $siswa->nama }}</td>
                
                {{-- Init Totals --}}
                @php
                    $h = 0; $s = 0; $i = 0; $a = 0;
                @endphp

                @for ($day = 1; $day <= 31; $day++)
                    @php
                        // Construct date Y-m-d
                        $date = \Carbon\Carbon::create($year, $month, $day)->format('Y-m-d');
                        // Find absensi record for this student on this day
                        $absensi = $siswa->absensis->firstWhere('tanggal', $date);
                        $status = strtolower($absensi ? $absensi->status : '');
                        
                        // Default code
                        $code = '';
                        if ($status == 'hadir') { $code = '.'; $h++; }
                        elseif ($status == 'sakit') { $code = 'S'; $s++; }
                        elseif ($status == 'izin') { $code = 'I'; $i++; }
                        elseif ($status == 'alpa') { $code = 'A'; $a++; }
                    @endphp
                    <td style="border: 1px solid black; text-align: center; 
                        {{ $code == 'S' ? 'background-color: #fef3c7;' : '' }}
                        {{ $code == 'I' ? 'background-color: #dbeafe;' : '' }}
                        {{ $code == 'A' ? 'background-color: #fee2e2;' : '' }}
                    ">
                        {{ $code }}
                    </td>
                @endfor

                {{-- Totals --}}
                <td style="border: 1px solid black; text-align: center; font-weight: bold;">{{ $h }}</td>
                <td style="border: 1px solid black; text-align: center; font-weight: bold;">{{ $s }}</td>
                <td style="border: 1px solid black; text-align: center; font-weight: bold;">{{ $i }}</td>
                <td style="border: 1px solid black; text-align: center; font-weight: bold;">{{ $a }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{-- Signature Section --}}
<br>
<table style="width: 100%; border: none;">
    <tr>
        <td colspan="5" style="border: none; text-align: center; vertical-align: top;">
            Mengetahui,<br>
            Kepala Sekolah
            <br><br><br><br><br>
            <strong>( ........................................... )</strong><br>
            NIP. ........................................
        </td>
        <td colspan="27" style="border: none;"></td>
        <td colspan="5" style="border: none; text-align: center; vertical-align: top;">
            Padang, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}<br>
            Wali Kelas {{ $kelas->nama_kelas }}
            <br><br><br><br><br>
            <strong>( ........................................... )</strong><br>
            NIP. ........................................
        </td>
    </tr>
</table>
