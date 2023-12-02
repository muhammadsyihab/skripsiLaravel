@php
    header('Cache-Control: no-cache, must-revalidate');
    header('Pragma: no-cache');
    header('Content-type: application/x-msexcel');
    header('Content-type: application/octet-stream');
    header('Content-Disposition: attachment; filename=Laporan-users' . '.xls');
@endphp


<!DOCTYPE html>
<html>

<head>
    <title>Pengguna - Report</title>
    <style>
        #master td {
            vertical-align: middle;

        }
    </style>
</head>

<body>
    <div style="text-align: center; font-size: 20px;">
        <b>DATA PENGGUNA</b>
    </div>

    <br>
    <table border="1" style="font-size: 14px;width: 50%;">
        <thead>
            <tr style="background-color: yellow">
                 <th class="text-center">Nama Pegawai</th>
                <th class="text-center">Lokasi</th>
                <th class="text-center">Jabatan</th>
                <th class="text-center">Email</th>
                <th class="text-center">No Telp</th>
                <th class="text-center">Jenis Kelamin</th>
                {{-- <th class="text-center">Foto</th> --}}
            </tr>
        </thead>
        <tbody>

          @foreach ($users as $u)
                <tr>
                    {{--  <td><img src="{{ asset('storage/Register/' . $u->photo) }}" height="60" width="60" alt=""></td>  --}}
                    <td>{{ $u->name }}</td>
                    @if (empty($u->master_lokasi_id))
                        <td>-</td>
                    @else
                        <td>{{ $u->nama_lokasi }}</td>
                    @endif
                    <td>{{ $u->jabatan }}</td>
                    <td>{{ $u->email }}</td>
                    <td>' {{ $u->no_telp }}</td>
                    <td>
                        @if ($u->jenis_kelamin === '0')
                            <p>Laki-Laki</p>
                        @else
                            <p>Perempuan</p>
                        @endif
                    </td>
                  
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>

</body>

</html>
