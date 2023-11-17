@extends('layouts.template')

@section('content')
    <style>
        #chartdiv {
            width: 100%;
            height: 500px;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <div id="layoutSidenav_content">
        <main>
            <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                <div class="container-xl px-4">
                    <div class="page-header-content pt-4">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mt-4">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="home"></i></div>
                                    Dashboard
                                </h1>
                                <div class="page-header-subtitle">
                                    {{ ENV('APP_NAME') }}
                                    <br>
                                    <span>{{ now()->translatedFormat('l') }}</span>
                                    &middot; {{ now()->translatedFormat('F j, Y') }} &middot;
                                    {{ now()->translatedFormat('g:i a') }}
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

                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">Grafik Status Unit</div>
                            <div class="card-body">
                                <div id="chartdiv"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (auth()->user()->role == 1 || auth()->user()->role == 0)
                    <div class="row">
                        <div class="col-xxl-12">
                            <!-- Tabbed dashboard card example-->
                            <div class="card mb-4">
                                <div class="card-header border-bottom">
                                    <!-- Dashboard card navigation-->
                                    <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                                        <li class="nav-item me-1"><a class="nav-link active" id="overview-pill"
                                                href="#overview" data-bs-toggle="tab" role="tab"
                                                aria-controls="overview" aria-selected="true">Laporan Kerusakan</a></li>
                                        {{-- <li class="nav-item"><a class="nav-link" id="activities-pill" href="#activities"
                                            data-bs-toggle="tab" role="tab" aria-controls="activities"
                                            aria-selected="false">Master Unit</a></li> --}}
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content" id="dashboardNavContent">
                                        <!-- Dashboard Tab Pane 1-->
                                        <div class="tab-pane fade show active" id="overview" role="tabpanel"
                                            aria-labelledby="overview-pill">
                                            <div class="table-responsive table-responsive-xxl text-nowrap mt-2">
                                                <table class="table table-bordered table-striped display"
                                                    id="datatablesSimple">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center">Nomor Lambung</th>
                                                            <th class="text-center">Waktu Insiden</th>
                                                            <th class="text-center">Kerusakan</th>
                                                            <th class="text-center">Prioritas</th>
                                                            <th class="text-center">Foto Insiden</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($tiket as $t)
                                                            <tr>
                                                                <td>{{ $t->units->no_lambung }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($t->waktu_insiden)->diffForHumans() }}
                                                                </td>
                                                                <td>{{ $t->judul }}</td>
                                                                {{-- prioritas --}}
                                                                @if ($t->prioritas === '0')
                                                                    <td> <span class="badge bg-secondary">Low</span> </td>
                                                                @elseif ($t->status_ticket === '1')
                                                                    <td> <span class="badge bg-warning">Medium</span></td>
                                                                @else
                                                                    <td><span class="badge bg-success">High</span></td>
                                                                @endif
                                                                {{-- prioritas --}}

                                                                @if (empty($t->photo) || $t->photo === 'null')
                                                                    <td class="text-center">
                                                                        <a href="https://unsplash.it/1200/768.jpg?image=250"
                                                                            data-toggle="lightbox"
                                                                            data-caption="This describes the image">
                                                                            <img src="{{ asset('storage/camera_default.png') }}"
                                                                                height="60" width="60"
                                                                                alt="">
                                                                        </a>
                                                                    </td>
                                                                @else
                                                                    <td class="text-center">
                                                                        <a href="{{ asset('storage/tiketPhoto/' . $t->photo) }}"
                                                                            data-toggle="lightbox"
                                                                            data-caption="This describes the image">
                                                                            <img src="{{ asset('storage/tiketPhoto/' . $t->photo) }}"
                                                                                height="60" width="60"
                                                                                alt="">
                                                                        </a>
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- Dashboard Tab Pane 2-->
                                        <div class="tab-pane fade" id="activities" role="tabpanel"
                                            aria-labelledby="activities-pill">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">

                    @if (auth()->user()->role == 1 || auth()->user()->role == 0)
                        <div class="col-12">

                            @if (auth()->user()->role == 0)
                                <div class="card mb-4">
                                    <div class="card-header">
                                        Lokasi PIT
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content" id="dashboardNavContent">
                                            <!-- Dashboard Tab Pane 1-->
                                            <div class="tab-pane fade show active" id="overview" role="tabpanel"
                                                aria-labelledby="overview-pill">
                                                <div class="table-responsive text-nowrap">
                                                    <table class="table table-bordered table-bordered display"
                                                        id="datatablesSimple">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">Nama Lokasi</th>
                                                                <th class="text-center">Lokasi</th>
                                                                <th class="text-center">Radius (Meter)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($lokasi as $lok)
                                                                <tr>
                                                                    <td>{{ $lok->nama_lokasi }}</td>
                                                                    @if (empty($lok->lattitude) && empty($lok->longtitude))
                                                                        <td>-</td>
                                                                    @else
                                                                        <td>{{ $lok->lattitude }} - {{ $lok->longtitude }}
                                                                        </td>
                                                                    @endif
                                                                    @if (empty($lok->radius))
                                                                        <td>-</td>
                                                                    @else
                                                                        <td>{{ $lok->radius }}</td>
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <!-- Dashboard Tab Pane 2-->
                                            <div class="tab-pane fade" id="activities" role="tabpanel"
                                                aria-labelledby="activities-pill">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('lokasi.index') }}">Lihat Detail..</a>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="col-8">
                        <!-- Tabbed dashboard card example-->

                    </div>
                </div>
                @if (auth()->user()->role == 2 || auth()->user()->role == 0)
                    <div class="row mb-3">
                        <div class="col-12">
                            <!-- Bar chart example-->
                            <div class="card h-100">
                                <div class="card-header">Grafik Barang {{ now()->translatedFormat('F Y') }}</div>
                                <div class="card-body justify-content-center">
                                    <div>
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>
                                <div class="card-footer position-relative">
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
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
    {{-- <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs5-lightbox@1.8.3/dist/index.bundle.min.js"></script>

    <script>
        document.querySelectorAll('.my-lightbox-toggle').forEach((el) => el.addEventListener('click', (e) => {
            e.preventDefault();
            const lightbox = new Lightbox(el, options);
            lightbox.show();
        }));
        $(document).ready(function() {
            $('table.display').DataTable({
                lengthMenu: [
                    [5, 10, 15, -1],
                    [5, 10, 15, 'All'],
                ],
            });
        });

        let label = [];
        //$.ajax({
        //    type: "GET",
        //   dataType: "json",
        //    url: "{{ route('home.sparepart') }}",
        //    success: function(data) {

        // console.log(data);
        //dataArray = Object.values(data);
        //label.push(...dataArray);
        // console.log(dataArray);

        //},
        //error: function(err) {
        //    console.log(err.responseText);
        //}
        // });

        let qty = [];
        let qty2 = [];
        @foreach ($cekSparepart as $sp)
            qty2.push({{ $sp->total }})
            label.push('{{ $sp->sparepart->nama_item }}')
        @endforeach
        //$.ajax({
        //    type: "GET",
        //    dataType: "json",
        //    url: "{{ route('home.sparepart.qty') }}",
        //    success: function(data) {

        // console.log(data);
        //dataArrayQty = Object.values(data);
        //qty.push(...dataArrayQty);


        //},
        //error: function(err) {
        //   console.log(err.responseText);
        // }
        //});


        console.log(qty2)
        const ctx = document.getElementById('myChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: label,
                datasets: [{
                    label: '# Data Sparepart Keluar',
                    data: qty2,
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // chart unit

        am5.ready(function() {


            // Create root element
            // https://www.amcharts.com/docs/v5/getting-started/#Root_element
            var root = am5.Root.new("chartdiv");


            var myTheme = am5.Theme.new(root);

            myTheme.rule("Grid", ["base"]).setAll({
                strokeOpacity: 0.1
            });


            // Set themes
            // https://www.amcharts.com/docs/v5/concepts/themes/
            root.setThemes([
                am5themes_Animated.new(root),
                myTheme
            ]);


            // Create chart
            // https://www.amcharts.com/docs/v5/charts/xy-chart/
            var chart = root.container.children.push(am5xy.XYChart.new(root, {
                panX: false,
                panY: false,
                wheelX: "panY",
                wheelY: "zoomY",
                layout: root.verticalLayout
            }));

            // Add scrollbar
            // https://www.amcharts.com/docs/v5/charts/xy-chart/scrollbars/
            chart.set("scrollbarY", am5.Scrollbar.new(root, {
                orientation: "vertical"
            }));

            var data = [{
                "category": "Breakdown",
                @foreach ($data as $item)
                    @if ($item->status_unit == 2)
                        "{{ strtolower($item->jenis) }}": {{ round($item->persentase, 2) }},
                    @endif
                @endforeach
            }, {
                "category": "Ready",
                @foreach ($data as $item)
                    @if ($item->status_unit == 0)
                        "{{ strtolower($item->jenis) }}": {{ round($item->persentase, 2) }},
                    @endif
                @endforeach
            }, {
                "category": "Work",
                @foreach ($data as $item)
                    @if ($item->status_unit == 1)
                        "{{ strtolower($item->jenis) }}": {{ round($item->persentase, 2) }},
                    @endif
                @endforeach
            }, ]


            // Create axes
            // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
            var yRenderer = am5xy.AxisRendererY.new(root, {});
            var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
                categoryField: "category",
                renderer: yRenderer,
                tooltip: am5.Tooltip.new(root, {})
            }));

            yRenderer.grid.template.setAll({
                location: 1
            })

            yAxis.data.setAll(data);

            var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
                min: 0,
                max: 100,
                renderer: am5xy.AxisRendererX.new(root, {
                    strokeOpacity: 0.1
                })
            }));

            // Add legend
            // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
            var legend = chart.children.push(am5.Legend.new(root, {
                centerX: am5.p50,
                x: am5.p50
            }));


            // Add series
            // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
            function makeSeries(name, fieldName) {
                var series = chart.series.push(am5xy.ColumnSeries.new(root, {
                    name: name,
                    stacked: true,
                    xAxis: xAxis,
                    yAxis: yAxis,
                    baseAxis: yAxis,
                    valueXField: fieldName,
                    categoryYField: "category"
                }));

                series.columns.template.setAll({
                    tooltipText: "{name}, {categoryY}: {valueX}",
                    tooltipY: am5.percent(90)
                });
                series.data.setAll(data);

                // Make stuff animate on load
                // https://www.amcharts.com/docs/v5/concepts/animations/
                series.appear();

                series.bullets.push(function() {
                    return am5.Bullet.new(root, {
                        sprite: am5.Label.new(root, {
                            text: "{valueX}%",
                            fill: root.interfaceColors.get(
                                "alternativeText"),
                            centerY: am5.p50,
                            centerX: am5.p50,
                            populateText: true
                        })
                    });
                });

                legend.data.push(series);
            }

            @foreach ($jenisUnit as $ju)
                makeSeries("{{ $ju->jenis }}", "{{ strtolower($ju->jenis) }}");
            @endforeach
            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            chart.appear(1000, 100);

        }); // end am5.ready()
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
            'https://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
                attribution: 'Map by <a href="https://maps.google.com/">Google</a>',

                subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
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
            zoom: 11,
            layers: [peta2]
        });

        var baseMaps = {
            "Default": peta2,
            "OpenStreetMap": peta3,
        };

        var greenIcon = new L.Icon({
            iconUrl: 'https://dev-aneka2.neuhost.co.id/icon/truck.png',
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
        @foreach ($lokasi as $l)
            var lokasi = L.circle([{{ $l->lattitude }}, {{ $l->longtitude }}], {
                "radius": "{{ $l->radius }}",
                "fillColor": "#ff7800",
                "color": "#ff7800",
                "weight": 1,
                "opacity": 0.5,
                "fillOpacity": 0.5,
                'strokeOpacity': 0.5
            }).addTo(mymap).bindPopup("<b>Area : {{ $l->nama_lokasi }} </b>");
        @endforeach

        @foreach ($units as $unit)
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
