<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <title>Laporan Pengguna</title>
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
        <h3>DAFTAR PENGGUNA</h3>
        <p>di cetak pada tanggal : {{ date('d-M-Y') }}</p>
    </div>
    <br>

    <table class="">
        <thead>
            <tr style="background-color: yellow">
                <th class="text-center">Nama Pegawai</th>
                <th class="text-center">Lokasi</th>
                <th class="text-center">Jabatan</th>
                <th class="text-center">Email</th>
                <th class="text-center">No Telp</th>
                <th class="text-center">Jenis Kelamin</th>

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
                    <td>{{ $u->no_telp }}</td>
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
</body>
<script>
    $('table').rowspanizer();
</script>

</html>
