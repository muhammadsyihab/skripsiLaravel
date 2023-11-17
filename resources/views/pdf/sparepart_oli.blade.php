<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <title>Laporan Oli</title>
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
        <h3>DAFTAR OLI</h3>
        <p>di cetak pada tanggal : {{ date('d-M-Y') }}</p>
    </div>
    <br>

    <table class="">
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
            @foreach ($spareparts as $item)
                <tr>
                    <td>{{ $item->part_number }}</td>
                    <td>{{ $item->nama_item }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ $item->uom }}</td>
                    @if ($item->item_price == null)
                        <td>Price Belum di Update</td>
                        <td>Price Belum di Update</td>
                    @else
                        <td>@currency($item->item_price)</td>
                        <td>@currency($item->item_price * $item->qty)</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
<script>
    $('table').rowspanizer();
</script>

</html>
