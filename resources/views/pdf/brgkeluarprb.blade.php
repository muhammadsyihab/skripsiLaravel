<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <title>Laporan Barang Keluar Pribadi</title>
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
            font-size: 9px;
        }

        th {
            font-size: 11px;
        }

        .tengah {
            text-align: center;
            line-height: 5px;
        }
    </style>
</head>

<body>
    <div class="tengah">
        <h3>DAFTAR BARANG KELUAR PRIBADI</h3>
        <p>di cetak pada tanggal : {{ date('d-M-Y') }}</p>
    </div>
    <br>
    <table class="">
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
                        <td>Diminta</td>
                    @elseif($bk->status == 1)
                        <td>Acc</td>
                    @elseif($bk->status == 2)
                        <td>Menunggu PIC</td>
                    @elseif($bk->status == 3)
                        <td>Acc PIC</td>
                    @elseif($bk->status == 4)
                        <td>Ditolak</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <th colspan="8">Grand Total</th>
            <th colspan="3">@currency($total)</th>
        </tfoot>
    </table>
</body>
<script>
    $('table').rowspanizer();
</script>

</html>
