<table class="table table-bordered">
    <tr>
        <th>Jam Kerja Masuk</th>
        <th>Jam Kerja Keluar</th>
    </tr>
    @foreach ($tagline as $item)
        <tr>
            <td>{{ Carbon\carbon::parse($item->jam_kerja_masuk)->translatedFormat('l, d F Y g:i A') }}</td>
            <td>{{ Carbon\carbon::parse($item->jam_kerja_keluar)->translatedFormat('l, d F Y g:i A') }}</td>
        </tr>
    @endforeach
</table>
