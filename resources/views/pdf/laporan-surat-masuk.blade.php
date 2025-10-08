<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Surat Masuk</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 0; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Surat Masuk</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($tanggal_selesai)->format('d M Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Surat</th>
                <th>Perihal</th>
                <th>Pengirim</th>
                <th>Tgl. Surat</th>
                <th>Tgl. Diterima</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($surat as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->nomor_surat }}</td>
                    <td>{{ $item->perihal }}</td>
                    <td>{{ $item->pengirim }}</td>
                    <td>{{ $item->tanggal_surat->format('d-m-Y') }}</td>
                    <td>{{ $item->tanggal_diterima->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
