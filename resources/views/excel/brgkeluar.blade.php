@php
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Content-type: application/x-msexcel');
    header('Content-type: application/octet-stream');
    header('Content-Disposition: attachment; filename=Laporan-Barang-Keluar' . '.xls');
@endphp


<!DOCTYPE html>
<html>

<head>
    <title>Barang Keluar - Report</title>
    <style>
        #master td {
            vertical-align: middle;

        }
    </style>
</head>

<body>
    <div style="text-align: center; font-size: 20px;">
        <b>DATA BARANG KELUAR</b>
    </div>

    <br>
    <table border="1" style="font-size: 14px;width: 50%;">
        <thead>
            <tr style="background-color: yellow">
                <th class="text-center">Tanggal</th>
                <th class="text-center">Area</th>
                <th class="text-center">Kode Unit</th>
                <th class="text-center">Nomor Part</th>
                <th class="text-center">Deskripsi</th>
                <th class="text-center">Penerima</th>
                <th class="text-center">QTY</th>
                <th class="text-center">UOM</th>
                <th class="text-center">Harga Satuan (RP)</th>
                <th class="text-center">Total (RP)</th>
                <th class="text-center">Remarks / Request By</th>
                <th class="text-center">Status</th>
                {{-- <th class="text-center">Foto</th> --}}
            </tr>
        </thead>
        <tbody>

           @foreach ($brgkeluar as $bk)
                <tr>
                    <td>{{ now()->parse($bk->tanggal_keluar)->format('j F Y') }}</td>
                    <td>{{ $bk->lokasi->nama_lokasi }}</td>
                    <td>{{ $bk->unit->no_lambung }}</td>
                    <td>{{ $bk->sparepart->part_number }}</td>
                    <td>{{ $bk->sparepart->nama_item }}</td>
                    <td>{{ $bk->penerima }}</td>
                    <td>{{ $bk->qty_keluar }}</td>
                    <td> {{ $bk->sparepart->uom }}</td>
                    <td>@currency($bk->sparepart->item_price)</td>
                    <td>@currency($bk->amount)</td>
                    <td>{{ $bk->users->name }}</td>
                    @if ($bk->status == 0)
                        <td><span class="badge bg-warning">Diminta</span></td>
                    @elseif($bk->status == 1)
                        <td><span class="badge bg-success">Acc</span></td>
                    @elseif($bk->status == 2 || $bk->status == 4)
                        <td><span class="badge bg-danger">Ditolak<span></td>
                    @endif
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <th colspan="5">Grand Total</th>
            <th colspan="3">@currency($total)</th>
        </tfoot>
    </table>
    <br>

</body>

</html>
