@extends('layouts.template')

@section('content')
    <div id="layoutSidenav_content">
        @if ($errors->any())
            <div class="alert alert-yellow">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
        @endif
        <main>
            <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                <div class="container-xl px-4">
                    <div class="page-header-content pt-4">
                    </div>
                </div>
            </header>
            <!-- Main page content-->
            <div class="container-xl px-4 mt-n10">
                <div class="row">
                    <div class="col-md-6">
                        {{--  <div class="card">
                            <div class="card-header">Lokasi MAP</div>
                            <div class="card-body">
                                <div id="mapid" style="height: 600px;"></div>
                            </div>
                        </div>  --}}
                    </div>
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Edit Lokasi</div>
                            <div class="card-body">
                                <form action="{{ route('lokasi.update', $lokasi->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
                                    <!-- INPUT -->
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="nama_lokasi">Nama Lokasi</label>
                                                <input class="form-control" placeholder="Nama Lokasi" name="nama_lokasi"
                                                    value="{{ $lokasi->nama_lokasi }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="lattitude">Latitude</label>
                                                <input class="form-control" placeholder="-3.477***" name="lattitude"
                                                    id="lattitude" value="{{ $lokasi->lattitude }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="longtitude">Longitude</label>
                                                <input class="form-control" placeholder="115.589***" name="longtitude"
                                                    id="longtitude" value="{{ $lokasi->longtitude }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="mb-3">
                                                <label for="radius">Radius</label>
                                                <input type="number" class="form-control" placeholder="Radius (meter)"
                                                    name="radius" min="0" value="{{ $lokasi->radius }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- End INPUT -->
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <a href="{{ route('lokasi.index') }}" class="btn btn-red btn-lg" role="button"
                                                aria-pressed="true">Kembali</a>
                                            <button class="btn btn-lg btn-teal" type="button" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalCenter">Simpan</button>

                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalCenterTitle">Apakah Anda
                                                                Yakin?</h5>
                                                            <button class="btn-close" type="button" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Data anda akan diperbaharui.
                                                            Pastikan form diatas telah terisi dengan benar!
                                                        </div>
                                                        <div class="modal-footer"><button class="btn btn-secondary"
                                                                type="button" data-bs-dismiss="modal">Tutup</button>
                                                            <button class="btn btn-primary" type="submit">Simpan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </main>
        <footer class="footer-admin mt-auto footer-light">
            <div class="container-xl px-4">
                <div class="row">
                    <div class="col-md-6 small">Copyright &copy; {{ env('APP_NAME') }}
                        <script type="text/javascript">
                            document.write(new Date().getFullYear());
                        </script>
                    </div>
                    <div class="col-md-6 text-md-end small">
                        <a href="#!"> </a>
                        &middot;
                        <a href="#!"> </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    </div>
@endsection
@section('script')
    <script>
        var curLocation = [0, 0];
        if (curLocation[0] == 0 && curLocation[1] == 0) {
            curLocation = [-3.477984, 115.589282];
        }

        var map = L.map('mapid').setView([-3.477984, 115.589282], 15);

        L.tileLayer(
            'https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                attribution: 'Map by <a href="https://maps.google.com/">Google</a>',
                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
            }).addTo(map);

        map.attributionControl.setPrefix(false);

        var marker = new L.marker(curLocation, {
            draggable: 'true'
        });

        marker.on('dragend', function(event) {
            var position = marker.getLatLng();
            marker.setLatLng(position, {
                draggable: 'true'
            }).bindPopup(position).update();
            $("#lattitude").val(position.lat);
            $("#longtitude").val(position.lng).keyup();
        });

        $("#lattitude,#longtitude").change(function() {
            var position = [parseInt($("#lattitude").val()), parseInt($("#longtitude").val())];
            marker.setLatLng(position, {
                draggable: 'true'
            }).bindPopup(position).update();
            map.panTo(position);
        });

        map.addLayer(marker);
    </script>
@endsection
