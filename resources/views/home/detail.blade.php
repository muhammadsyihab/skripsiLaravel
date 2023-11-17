@extends('layouts.template')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <div id="layoutSidenav_content">
        <main>
            <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                <div class="container-xl px-4">
                    <div class="page-header-content pt-4">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mt-4">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="map"></i></div>
                                    Detail Lokasi Unit {{ $map[0]->nama_lokasi }}
                                </h1>
                                <div class="page-header-subtitle">
                                    {{ ENV('APP_NAME') }}
                                    <br>
                                    <span>{{ now()->format('l') }}</span>
                                    &middot; {{ now()->format('F j, Y') }} &middot; {{ now()->format('g:i a') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Main page content-->
            <div class="container-xl px-6 mt-n10">
                <div class="row">
                    <div class="col-xxl-12">
                        <div class="card mb-4">
                            <div class="card-header">Lokasi Unit</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    @foreach ($lokasi as $lok)
                                        <a href="{{ route('area', $lok->id) }}" class="btn btn-outline-green btn-md"><i
                                                data-feather="map"></i> &nbsp; Area
                                            {{ $lok->nama_lokasi }}</a>
                                    @endforeach
                                </div>
                                <div id="progress">
                                    <div id="progress-bar"></div>
                                </div>
                                <div id="mapid" style="height: 475px;"></div>
                            </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        $(document).ready(function() {
            $('table.display').DataTable({
                lengthMenu: [
                    [5, 10, 15, -1],
                    [5, 10, 15, 'All'],
                ],
            });
        });
    </script>
@endsection
@section('script')
    <script>
        // Map BARU
        var peta1 = L.tileLayer(
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox/streets-v11'
            });

        var peta2 = L.tileLayer(
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox/satellite-v9'
            });


        var peta3 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        });

        var peta4 = L.tileLayer(
            'https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
                attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
                    '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
                    'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
                id: 'mapbox/dark-v10'
            });

        var mymap = L.map('mapid', {
            center: [-3.477984, 115.589282],
            zoom: 16,
            layers: [peta2]
        });

        var baseMaps = {
            "Default": peta1,
            "Satellite": peta2,
            "Streets": peta3,
            "Dark": peta4
        };

        var greenIcon = new L.Icon({
            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowSize: [41, 41]
        });

        L.control.layers(baseMaps).addTo(mymap);

        var progress = document.getElementById('progress');
        var progressBar = document.getElementById('progress-bar');

        function updateProgressBar(processed, total, elapsed, layersArray) {
            if (elapsed > 1000) {
                // if it takes more than a second to load, display the progress bar:
                progress.style.display = 'block';
                progressBar.style.width = Math.round(processed / total * 100) + '%';
            }

            if (processed === total) {
                // all markers processed - hide the progress bar:
                progress.style.display = 'none';
            }
        }

        {{--  MARKER CLUSTER Group  --}}
        var markers = L.markerClusterGroup({
            spiderfyOnMaxZoom: false,
            showCoverageOnHover: false,
            zoomToBoundsOnClick: true,
            chunkedLoading: true,
            chunkProgress: updateProgressBar,
            disableClusteringAtZoom: 16
        });

        var markerList = [];

        // menampilkan data pada map
        @foreach ($units as $unit)
            var lokasi = L.circle([{{ $unit->lattitude }}, {{ $unit->longtitude }}], {
                "radius": "{{ $unit->radius }}",
                "fillColor": "#ff7800",
                "color": "#ff7800",
                "weight": 1,
                "opacity": 1
            }).addTo(mymap);
            mymap.panTo(new L.latLng({{ $unit->lattitude }}, {{ $unit->longtitude }}));
            @if ($unit->latitude != null && $unit->longitude != null)
                var data = "<b> Nama Unit: {{ $unit->nama_unit }} </b></br>" +
                    "Lokasi : {{ $unit->nama_lokasi }}</br>" +
                    "Nomor Serial : {{ $unit->no_serial }}</br>" +
                    "Nomor Lambung : {{ $unit->no_lambung }}</br>" +
                    "Kepemilikan Unit : {{ $unit->status_kepemilikan }}";
                var marker = L.marker(L.latLng({{ $unit->latitude }}, {{ $unit->longitude }}), {
                    icon: greenIcon
                });
                marker.bindPopup(data);
                markers.addLayers(marker);
                mymap.addLayer(markers);
            @endif
        @endforeach
    </script>
@endsection
