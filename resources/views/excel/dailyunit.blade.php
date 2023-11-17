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
            font-size: 9px;
        }

        th {
            font-size: 11px;
        }
    </style>
</head>

<body>
    <table class="table table-bordered table-striped" id="datatablesSimple">
        <thead>
            <tr style="background-color: yellow">
                <th rowspan="2" class="text-center">Tanggal
                    Operasi</th>
                <th rowspan="2" class="text-center">Shift</th>
                <th rowspan="2" class="text-center">Nama Unit</th>
                <th colspan="2" class="text-center">HM</th>
                <th colspan="1" class="text-center">Time Operasional</th>
                <th rowspan="2" class="text-center">Solar
                </th>
                <th colspan="3" class="text-center">Time Sheet</th>
                <th rowspan="2" class="text-center">Operator/Driver
                </th>

            </tr>
            <tr style="background-color: yellow">
                <th class="text-center">Start</th>
                <th class="text-center">End</th>
                <th class="text-center">HM</th>
                <th class="text-center">WH</th>
                <th class="text-center">STB</th>
                <th class="text-center">BD</th>
            </tr>
        </thead>
        <tbody>

            @foreach ($dailys as $daily)
                <tr>

                    <td rowspan="1">{{ now()->parse($daily->tanggal)->format('j F Y') }}</td>
                    <td>{{ $daily->waktu }}</td>
                    <td>{{ $daily->no_lambung }}</td>
                    <td>{{ $daily->start_unit }}</td>
                    <td>{{ $daily->end_unit }}</td>
                    @if ($daily->end_unit == 0)
                        <td>Unit Masih Berjalan</td>
                    @else
                        <td>{{ $daily->end_unit - $daily->start_unit }}</td>
                    @endif
                    <td>{{ $daily->fuel }}</td>
                    @if ($daily->end_unit == 0)
                        <td>Unit Masih Berjalan</td>
                    @else
                        <td>{{ $daily->end_unit - $daily->start_unit }}</td>
                    @endif

                    @if (12 -
                            ($daily->end_unit - $daily->start_unit) -
                            now()->parse($daily->hm_bd)->diffInHours($daily->hm_bd_end) <
                            0)
                        <td>0</td>
                        <td>
                            {{ 12 - ($daily->end_unit - $daily->start_unit) }}
                        </td>
                    @else
                        <td>
                            {{ 12 -($daily->end_unit - $daily->start_unit) -now()->parse($daily->hm_bd)->diffInHours($daily->hm_bd_end) }}
                        </td>

                        <td>
                            {{ now()->parse($daily->hm_bd)->diffInHours($daily->hm_bd_end) }}
                        </td>
                    @endif
                    <td>{{ $daily->operator }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total</th>
                <th colspan="3">HM: {{ $totWh }}</th>
                <th></th>
                <th>WH: {{ $totWh }}</th>
                <th>STB: {{ $totStb }}</th>
                <th>BD: {{ $totBd }}</th>
                <th colspan=""></th>
            </tr>
            <tr>
                <th colspan="7">Akumulasi</th>
                <th colspan="">PA: {{ number_format((float) $pa, 2, '.', '') }} %</th>
                <th colspan="">UA: {{ number_format((float) $ua, 2, '.', '') }} %</th>
                <th colspan="">MA: {{ number_format((float) $ma, 2, '.', '') }} %</th>
                <th colspan="1"></th>
            </tr>
        </tfoot>
    </table>
</body>
<script>
    $('table').rowspanizer();
</script>

</html>
