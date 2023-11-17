@php
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Content-type: application/x-msexcel');
    header('Content-type: application/octet-stream');
    header('Content-Disposition: attachment; filename=Laporan-Barang-Keluar-Pribadi' . '.xls');
@endphp


<!DOCTYPE html>
<html>

<head>
    <title>Barang Keluar Pribadi - Report</title>
    <style>
        #master td {
            vertical-align: middle;

        }
    </style>
</head>

<body>
    <div style="text-align: center; font-size: 20px;">
        <b>DATA BARANG KELUAR PRIBADI</b>
    </div>

    <br>
    <table border="1" style="font-size: 14px;width: 50%;">
        <thead>
            <tr style="background-color: yellow">
                <th class="text-center">Date</th>
                <th class="text-center">Local Area</th>
                <th class="text-center">Code Unit</th>
                <th class="text-center">Part Number</th>
                <th class="text-center">Description</th>
                <th class="text-center">Penerima</th>
                <th class="text-center">QTY</th>
                <th class="text-center">Item Price</th>
                <th class="text-center">Amount</th>
                <th class="text-center">Estimasi</th>
                <th class="text-center">Status</th>
                {{-- <th class="text-center">Foto</th> --}}
            </tr>
        </thead>
        <tbody>

            @foreach ($brgkeluar as $bk)
                <tr>
                    <td>{{ now()->parse($bk->tanggal_keluar)->format('j F Y') }}</td>
                    <td>{{ $bk->unit->lokasi->nama_lokasi }}</td>
                    <td>{{ $bk->unit->no_lambung }}</td>
                    <td>{{ $bk->part_number }}</td>
                    <td>{{ $bk->nama_item }}</td>
                    <td>{{ $bk->user->name }}</td>
                    <td>{{ $bk->qty }} {{ $bk->uom }}</td>
                    <td>@currency($bk->item_price)</td>
                    <td>@currency($bk->amount)</td>
                    <td>{{ $bk->estimasi }} Jam</td>
                    @if ($bk->status == 0)
                        <td><span class="badge bg-warning">Diminta</span></td>
                    @elseif($bk->status == 1)
                        <td><span class="badge bg-success">Acc</span></td>
                    @elseif($bk->status == 2)
                        <td><span class="badge bg-warning">Menunggu PIC</span></td>
                    @elseif($bk->status == 3)
                        <td><span class="badge bg-primary">Acc PIC</span></td>
                    @elseif($bk->status == 4)
                        <td><span class="badge bg-danger">Ditolak</span></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <th colspan="8">Grand Total</th>
            <th colspan="3">@currency($total)</th>
        </tfoot>
    </table>
    <br>

</body>

</html>
