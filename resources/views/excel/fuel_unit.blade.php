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
    <table class="table table-bordered table-striped" id="simpleDatatables">
        <thead>
            <tr>
                <th class="text-center" valign="middle" rowspan="2">Tanggal</th>
                <th class="text-center" valign="middle" rowspan="2">Local Area</th>
                <th class="text-center" valign="middle" rowspan="2">Kode Unit / CN Unit</th>
                <th class="text-center" valign="middle" rowspan="2">Kuantitas Pengisian Unit
                </th>
                <th class="text-center" valign="middle" colspan="2">Fuel Rite</th>
                <th class="text-center" valign="middle" rowspan="2">HM Unit</th>
                <th class="text-center" valign="middle" rowspan="2">Shift</th>
                <th class="text-center" valign="middle" rowspan="2">Operator</th>
            </tr>
            <tr>
                <th class="text-center" valign="middle">Awal</th>
                <th class="text-center" valign="middle">Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($fuelToUnits as $fuelToUnit)
                <tr>
                    <td>{{ now()->parse($fuelToUnit->tanggal)->format('j F Y') }}</td>
                    <td>{{ $fuelToUnit->nama_lokasi }}</td>
                    <td>{{ $fuelToUnit->no_lambung }}</td>
                    <td>{{ $fuelToUnit->qty_to_unit }}</td>
                    <td>{{ $fuelToUnit->stock }}</td>
                    <td>{{ $fuelToUnit->stock - $fuelToUnit->qty_to_unit }}</td>
                    <td>{{ $fuelToUnit->total_hm }}</td>
                    @if ($fuelToUnit->shift == 1)
                        <td><span class="badge bg-warning">DAY</span></td>
                    @elseif($fuelToUnit->shift == 2)
                        <td><span class="badge bg-dark">NIGHT</span></td>
                    @endif
                    <td>{{ ucfirst($fuelToUnit->name) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
<script>
    $('table').rowspanizer();
</script>

</html>
