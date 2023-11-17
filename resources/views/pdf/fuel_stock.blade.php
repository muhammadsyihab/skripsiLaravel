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
            font-size: 15px;
        }

        th {
            font-size: 15px;
        }

        .tengah {
            text-align: center;
            line-height: 5px;
        }
    </style>
</head>

<body>
    <div class="tengah">
        <h3>DAFTAR FUEL STOCK</h3>
        <p>di cetak pada tanggal : {{ date('d-M-Y') }}</p>
    </div>
    <br>
    <table>
        <thead style="background-color: yellow">
            <tr>
                <th class="text-center" valign="middle" rowspan="2">Tanggal</th>
                {{-- <th class="text-center" valign="middle" rowspan="2">Lokasi Storage</th> --}}
                {{-- <th class="text-center" valign="middle" rowspan="2">Nama Storage</th> --}}
                <th class="text-center" valign="middle" rowspan="2">Stock Open</th>
                <th class="text-center" valign="middle" rowspan="2">Fuel Stock In</th>
                <th class="text-center" valign="middle" colspan="2">Fuel Out</th>
                <th class="text-center" valign="middle" rowspan="2">Fuel Out Total</th>
                <th class="text-center" valign="middle" rowspan="2">Stock</th>
            </tr>
            <tr>
                <th class="text-center" valign="middle">Day</th>
                <th class="text-center" valign="middle">Night</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($stocks as $stock)
                <tr>
                    <td>{{ now()->parse($stock->tanggal)->format('j F Y') }}</td>
                    <td>{{ $stock->stock_open_total }}</td>
                    <td>{{ $stock->fuelSuplies->sum('do_datang') }}</td>
                    <td>{{ $stock->qty_to_unit_day }}</td>
                    <td>{{ $stock->qty_to_unit_night }}</td>
                    <td>{{ $stock->fuelOuts->sum('qty_to_unit') }}</td>
                    <td>{{ $stock->stock }}</td>
                </tr>
            @endforeach
            <tr>
                <th colspan="2">-- {{ $total }}</th>
                <th>Total Masuk: {{ $stockSuply }}</th>
                <th colspan="2">Rata-rata:
                    {{ number_format((float) $rataStockUnit, 2, '.', '') }}</th>
                <th colspan="1">Total Keluar: {{ $stockUnit }}</th>
                <th colspan="1">Sisa Stock: {{ $sisaStock }}</th>
            </tr>
        </tbody>
    </table>
</body>
<script>
    $('table').rowspanizer();
</script>

</html>
