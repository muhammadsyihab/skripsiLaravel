<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <title>Laporan Unit</title>
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
        <h3>DAFTAR UNIT</h3>
        <p>di cetak pada tanggal : {{ date('d-M-Y') }}</p>
    </div>
    <br>
    <table class="">
        <thead style="background-color: yellow">
            <tr>
                <th class="text-center">Type</th>
                <th class="text-center">Aset</th>
                <th class="text-center">Nomor Serial</th>
                <th class="text-center">Nomor Lambung</th>
                <th class="text-center">Status</th>
                <th class="text-center">Keterangan</th>
                <th class="text-center">Local Area</th>
                <th class="text-center">HM/KM</th>
                <th class="text-center">Service</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($units as $unit)
                <tr>
                    <td style="background-color:greenyellow">{{ $unit->jenis }}</td>
                    <td style="text-align: center;">{{ $unit->status_kepemilikan }}</td>
                    <td>{{ $unit->no_serial }}</td>
                    <td>{{ $unit->no_lambung }}</td>
                    @if ($unit->status_unit === '0')
                        <td style="text-align: center;">Ready</td>
                    @elseif ($unit->status_unit === '1')
                        <td style="text-align: center;">Completed Part</td>
                    @elseif ($unit->status_unit === '2')
                        <td style="text-align: center;">
                            <p style="color: red">Breakdown</p>
                        </td>
                    @elseif ($unit->status_unit === '3')
                        <td style="text-align: center;">Terjadwal</td>
                    @endif
                    <td>{{ $unit->keterangan }}</td>
                    <td style="text-align: center;">{{ $unit->nama_lokasi }}</td>
                    <td style="text-align: center;">{{ $unit->total_hm }}</td>
                    <td style="text-align: center;">{{ $unit->hm_triger }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
<script>
    $('table').rowspanizer();
</script>

</html>
