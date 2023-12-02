<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <title>Laporan Barang Keluar</title>
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
        <h3>DAFTAR BARANG KELUAR</h3>
        <p >di cetak pada tanggal : {{ date('d-M-Y') }}</p>
    </div>
    <br>

    <table class="">
        <thead>
            <tr style="background-color: yellow">
                <th class="text-center">Tanggal</th>
                <th class="text-center">Area</th>
                <th class="text-center">Kode Unit</th>
                <th class="text-center">Nomor Part</th>
                <th class="text-center">Deskripsi</th>
                <th class="text-center">Penerima</th>
                <th class="text-center">QTY</th>
                <th class="text-center">UOM</th>
                <th class="text-center">Harga Satuan (RP)</th>
                <th class="text-center">Total (RP)</th>
                <th class="text-center">Remarks / Request By</th>
                <th class="text-center">Status</th>
                {{-- <th class="text-center">Foto</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($brgkeluar as $bk)
                <tr>
                    <td>{{ now()->parse($bk->tanggal_keluar)->format('j F Y') }}</td>
                    <td>{{ $bk->lokasi->nama_lokasi }}</td>
                    <td>{{ $bk->unit->no_lambung }}</td>
                    <td>{{ $bk->sparepart->part_number }}</td>
                    <td>{{ $bk->sparepart->nama_item }}</td>
                    <td>{{ $bk->penerima }}</td>
                    <td>{{ $bk->qty_keluar }}</td>
                    <td> {{ $bk->sparepart->uom }}</td>
                    <td>@currency($bk->sparepart->item_price)</td>
                    <td>@currency($bk->amount)</td>
                    <td>{{ $bk->users->name }}</td>
                    @if ($bk->status == 0)
                        <td><span class="badge bg-warning">Diminta</span></td>
                    @elseif($bk->status == 1)
                        <td><span class="badge bg-success">Acc</span></td>
                    @elseif($bk->status == 2 || $bk->status == 4)
                        <td><span class="badge bg-danger">Ditolak<span></td>
                    @endif
                    {{-- @if (empty($bk->sparepart->photo))
                        <td class="text-center"><img src="{{ asset('storage/camera_default.png') }}" height="60"
                                width="60" alt=""></td>
                    @else
                        <td><img src="{{ asset('storage/spKeluar/' . $bk->sparepart->photo) }}"
                                height="50"width="50" alt=""></td>
                    @endif --}}
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
<script>
    $('table').rowspanizer();
</script>

</html>
