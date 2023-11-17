@php
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Content-type: application/x-msexcel');
    header('Content-type: application/octet-stream');
    header('Content-Disposition: attachment; filename=History-Semua-Laporan-Kerusakan' . '.xls');
@endphp


<!DOCTYPE html>
<html>

<head>
    <title>Daftar Semua Laporan Kerusakan - Report</title>
    <style>
        #master td {
            vertical-align: middle;

        }
    </style>
</head>

<body>
    <div style="text-align: center; font-size: 20px;">
        <b>DAFTAR HISTORY SEMUA LAPORAN KERUSAKAN</b>
    </div>

    <br>
    <table border="1" style="font-size: 14px;width: 50%;">
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

            @forelse ($tiket as $t)
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

                    {{--  <td class="align-middle">
                                                <div class="row">
                                                    <div class="d-flex justify-content-between">
                                                        <a class="btn btn-info btn-sm"
                                                            href="{{ route('ticket.vue.show', $t->id) }}"><i
                                                                class="fas fa-eye"></i>&nbsp;Show</a>&nbsp;
                                                        <a class="btn btn-warning btn-sm"
                                                            href="{{ route('ticket.edit', $t->id) }}"><i
                                                                class="fas fa-pen"></i>&nbsp;Edit</a>&nbsp;
                                                    </div>
                                                </div>
                                            </td>  --}}
                </tr>
            @empty
                <tr>
                    <td class="text-center" colspan="">Tidak ada data untuk ditampilkan</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <br>

</body>

</html>
