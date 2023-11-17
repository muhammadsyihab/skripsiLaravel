@php
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Content-type: application/x-msexcel');
    header('Content-type: application/octet-stream');
    header('Content-Disposition: attachment; filename=Laporan-Barang-Keluar' . '.xls');
@endphp


*
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <title>Breakdown Report</title>
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
                <th class="text-center">#</th>
                <th class="text-center">Nomor Lambung</th>
                @ho
                    <th class="text-center">Local Area</th>
                @endho
                <th class="text-center">Nama Pembuat</th>
                <th class="text-center">Waktu Insiden</th>
                <th class="text-center">Kerusakan</th>
                <th class="text-center">Status</th>
                <th class="text-center">Prioritas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tiket as $t)
                <tr>
                    <td>00{{ $t->id }}</td>
                    <td>{{ $t->no_lambung }}</td>
                    @ho
                        <td>{{ $t->nama_lokasi }}</td>
                    @endho
                    <td>{{ $t->name }}</td>
                    <td>{{ \Carbon\Carbon::parse($t->waktu_insiden)->diffForHumans() }}</td>
                    <td>{{ $t->judul }}</td>
                    {{-- status tiket --}}
                    @if ($t->status_ticket === '0')
                        <td>Tiket Dibuat</td>
                    @elseif ($t->status_ticket === '1')
                        <td>Analisa Mekanik</td>
                    @elseif ($t->status_ticket === '2')
                        <td>Laporan Mekanik</td>
                    @elseif ($t->status_ticket === '3')
                        <td>Proses Planner</td>
                    @elseif ($t->status_ticket === '4')
                        <td>Tindakan Planner</td>
                    @elseif ($t->status_ticket === '5')
                        <td>Proses Logistik</td>
                    @elseif ($t->status_ticket === '6')
                        <td>Tindakan Logistik</td>
                    @elseif ($t->status_ticket === '7')
                        <td>Proses GL</td>
                    @elseif ($t->status_ticket === '8')
                        <td>Implementasi Mekanik</td>
                    @else
                        <td><span class="badge bg-success">Selesai</span></td>
                    @endif
                    {{-- status tiket --}}
                    {{-- prioritas --}}
                    @if ($t->prioritas === '0')
                        <td> <span class="badge bg-secondary">Low</span> </td>
                    @elseif ($t->status_ticket === '1')
                        <td> <span class="badge bg-warning">Medium</span></td>
                    @else
                        <td><span class="badge bg-success">High</span></td>
                    @endif
                    {{-- prioritas --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
<script>
    $('table').rowspanizer();
</script>

</html>
