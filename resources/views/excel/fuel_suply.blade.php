@php
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Content-type: application/x-msexcel');
    header('Content-type: application/octet-stream');
    header('Content-Disposition: attachment; filename=Laporan-Barang-Masuk' . '.xls');
@endphp

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <title>Master Unit</title>
    <style>
        table,
        th,
        td {
            border: 1px solid;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }

        td {
            font-size: 12;
        }

        th {
            font-size: 12;
            background-color: yellow;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th class="text-center">Tanggal</th>
                <th class="text-center">Lokasi</th>
                <th class="text-center">Pengiriman</th>
                <th class="text-center">Plat Nomor Kendaraan</th>
                <th class="text-center">No Surat Jalan</th>
                <th class="text-center">Driver</th>
                <th class="text-center">Penerima</th>
                <th class="text-center">Nama Storage</th>
                <th class="text-center">TC Storage Sebelum (CM)</th>
                <th class="text-center">TC Storage Sesudah (CM)</th>
                <th class="text-center">Kenaikan Storage Setelah Isi</th>
                <th class="text-center">Suhu Diterima (CELCIUS)</th>
                <th class="text-center">QTY By DO</th>
                <th class="text-center">DO Yang Datang</th>
                <th class="text-center">DO Minus / Lebih</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fuelSuplies as $suplier)
                <tr>
                    <td>{{ now()->parse($suplier->tanggal)->format('j F Y') }}
                    </td>
                    {{-- <td>
                        {{ $suplier->storage->lokasi->nama_lokasi }}
                    </td> --}}
                    <td>OTW</td>
                    <td>{{ $suplier->transporter }}</td>
                    <td>{{ $suplier->no_plat_kendaraan }}</td>
                    <td>{{ $suplier->no_surat_jalan }}</td>
                    <td>{{ $suplier->driver }}</td>
                    <td>{{ $suplier->penerima }}</td>
                    {{-- <td>{{ $suplier->storage->nama_storage }}</td> --}}
                    <td>OTW</td>
                    <td>{{ $suplier->tc_storage_sebelum }} CM</td>
                    <td>{{ $suplier->tc_storage_sesudah }} CM</td>
                    <td>{{ $suplier->tc_kenaikan_storage }} CM</td>
                    <td>{{ $suplier->suhu_diterima }} CELCIUS</td>
                    <td>{{ $suplier->qty_by_do }} Liter</td>
                    <td>{{ $suplier->do_datang }} Liter</td>
                    <td>{{ $suplier->do_minus }} Liter</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="12">Total</th>
                <th>QTY By DO: {{ $totalByDo[0]->totalByDo }} Liter</th>
                <th>DO Datang: {{ $totalDoDatang[0]->totalDoDatang }} Liter</th>
                <th colspan="1">Do Minus: {{ $totalDoM[0]->totalDoM }} Liter</th>
            </tr>
        </tfoot>
    </table>
</body>
<script>
    $('table').rowspanizer();
</script>

</html>
