@php
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Content-type: application/x-msexcel');
    header('Content-type: application/octet-stream');
    header('Content-Disposition: attachment; filename=Laporan-Purchasing-Order' . '.xls');
@endphp


<!DOCTYPE html>
<html>

<head>
    <title>Purchasing Order - Report</title>
    <style>
        #master td {
            vertical-align: middle;

        }
    </style>
</head>

<body>
    <div style="text-align: center; font-size: 20px;">
        <b>DATA PURCHASING ORDER</b>
    </div>

    <br>
    <table border="1" style="font-size: 14px;width: 50%;">
        <thead>
            <tr style="background-color: yellow">
                <th class="text-center">Tanggal</th>
                <th class="text-center">Deskripsi</th>
                <th class="text-center">Nomor Part</th>
                <th class="text-center">QTY</th>
                <th class="text-center">Harga Satuan (RP)</th>
                <th class="text-center">Total (RP)</th>
                <th class="text-center">Suplier</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>

            @forelse ($brgmasuk as $brg)
                <tr>
                    <td>{{ now()->parse($brg->tanggal_masuk)->format('j F Y') }}</td>
                    <td>{{ $brg->sparepart->nama_item }}</td>
                    <td>{{ $brg->sparepart->part_number }}</td>
                    <td>{{ $brg->qty_masuk }} {{ $brg->sparepart->uom }}</td>

                    <td>@currency($brg->item_price)</td>
                    <td>@currency($brg->amount)</td>
                    <td>{{ $brg->vendor }}</td>
                    @if ($brg->status === 0)
                        <td><span class="badge bg-success">Diterima</span></td>
                    @else
                        <td><span class="badge bg-warning">Pre Order</span></td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="8">Tidak ada data untuk ditampilkan</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <th colspan="5">Grand Total</th>
            <th colspan="3">@currency($total)</th>
        </tfoot>
    </table>
    <br>

</body>

</html>
