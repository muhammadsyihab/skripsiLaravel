@php
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Content-type: application/x-msexcel');
    header('Content-type: application/octet-stream');
    header('Content-Disposition: attachment; filename=Laporan-Sparepart-Oli' . '.xls');
@endphp


<!DOCTYPE html>
<html>

<head>
    <title>Sparepart Oli - Report</title>
    <style>
        #master td {
            vertical-align: middle;

        }
    </style>
</head>

<body>
    <div style="text-align: center; font-size: 20px;">
        <b>DATA SPAREPART OLI</b>
    </div>

    <br>
    <table border="1" style="font-size: 14px;width: 50%;">
        <thead>
            <tr style="background-color: yellow">
                <th class="text-center">Part Number</th>
                <th class="text-center">Deskripsi</th>
                <th class="text-center">QTY</th>
                <th class="text-center">UOM</th>
                <th class="text-center">Item Price</th>
                <th class="text-center">Amount</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($spareparts as $item)
                <tr>
                    <td class="text-center">{{ $item->part_number }}</td>
                    <td class="text-center">{{ $item->nama_item }}</td>
                    <td class="text-center">{{ $item->qty }}</td>
                    <td class="text-center">{{ $item->uom }}</td>
                    @if ($item->item_price == null)
                        <td class="text-center">Price Belum di Update</td>
                        <td class="text-center">Price Belum di Update</td>
                    @else
                        <td class="text-center">@currency($item->item_price)</td>
                        <td class="text-center">@currency($item->item_price * $item->qty)</td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="6">Tidak ada data untuk ditampilkan</td>
                </tr>
            @endforelse

        </tbody>
    </table>
    <br>

</body>

</html>
