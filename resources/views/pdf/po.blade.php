<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <title>Laporan Purchasing Order</title>
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
        <h3>DAFTAR PURCHASING ORDER</h3>
        <p>di cetak pada tanggal : {{ date('d-M-Y') }}</p>
    </div>
    <br>

    <table class="">
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
            @foreach ($brgmasuk as $brg)
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
            @endforeach
        </tbody>
    </table>
</body>
<script>
    $('table').rowspanizer();
</script>

</html>
