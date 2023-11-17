@extends('layouts.template')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
.select2-container {
  width: 100% !important;
  max-width: 100% !important;
}

.select2-selection {
  border: 1px solid #ccc !important;
  border-radius: 4px !important;
}

.select2-selection__rendered {
  font-size: 16px !important;
}

</style>
    @livewireStyles
        <div id="layoutSidenav_content">
            <main>
                <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                    <div class="container-xl px-4">
                        <div class="page-header-content pt-4">
                        </div>
                    </div>
                </header>
                
                <div class="container-xl px-4 mt-n10">
                    <div class="card">
                        <div class="card-header border-bottom bg-white">
                            <!-- Dashboard card navigation-->
                            <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                                <li class="nav-item"><a class="nav-link active" id="histories-pill" href="#histories"
                                        data-bs-toggle="tab" role="tab" aria-controls="histories"
                                        aria-selected="true">Riwayat</a></li>
                                <li class="nav-item"><a class="nav-link" id="information-pill" href="#information"
                                        data-bs-toggle="tab" role="tab" aria-controls="information"
                                        aria-selected="true">Informasi</a></li>
                                <li class="nav-item"><a class="nav-link" id="timeline-pill" href="#timeline" data-bs-toggle="tab"
                                        role="tab" aria-controls="timeline" aria-selected="false">Riwayat Unit</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="dashboardNavContent">
                                <!-- Information Tab Pane 1-->
                                <div class="tab-pane position-relative fade show active" id="histories" role="tabpanel" aria-labelledby="histories-pill">
                                    <div class="row justify-content-start mb-2" id="chats">
                                        <div class="col-9">                                    
                                            {{-- Chats --}}
                                            @livewire('chats', ['pengaduanId' => $pengaduan->id])
                                            {{-- End Chats --}}
                                        </div>
                                        <div class="col-3">
                                            <div class="nav-sticky">
                                                <div class="card">
                                                    <div class="card-header bg-white text-muted">
                                                        Tindakan
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="nav flex-column" id="stickyNav">
                                                            @planner
                                                            <li class="nav-item mb-2">
                                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#permintaanSparepart">
                                                                    Permintaan Sparepart
                                                                </button>
                                                            </li>
                                                            @endplanner
                                                            @logistik
                                                            <li class="nav-item mb-2">
                                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#persetujuanLogistik">
                                                                    Persetujuan Permintaan
                                                                </button>
                                                            </li>
                                                            <li class="nav-item mb-2">
                                                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#pribadiLogistik">
                                                                    Pembelian Pribadi
                                                                </button>
                                                            </li>
                                                            @endlogistik
                                                            @ho
                                                            <li class="nav-item mb-2">
                                                                <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#persetujuanHO">
                                                                    Persetujuan Permintaan
                                                                </button>
                                                            </li>
                                                            @endho
                                                            @planner
                                                            <li class="nav-item mb-2">
                                                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#tutupTicket">
                                                                    Tutup Pengaduan
                                                                </button>
                                                            </li>
                                                            @endplanner
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            @livewire('tindakan', ['pengaduanId' => $pengaduan->id, 'masterUnitId' => $pengaduan->master_unit_id])
                                        </div>
                                    </div>
                                    <div class="position-sticky bottom-0 bg-white shadow-lg rounded" id="navbar" style="width: 100%">
                                        @livewire('post-chat', ['pengaduanId' => $pengaduan->id])
                                    </div>
                                </div>
                                <!-- Information Tab Pane 2-->
                                <div class="tab-pane fade" id="information" role="tabpanel"
                                    aria-labelledby="information-pill">
                                    <div class="row">
                                        <div class="col-8">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-center">
                                                            @if (empty($pengaduan->photo) || $pengaduan->photo === 'null')
                                                                <img src="{{ asset('storage/camera_default.png') }}" height="300" width="300" alt="">
                                                            @else
                                                                <img src="{{ asset('storage/tiketPhoto/' . $pengaduan->photo) }}" height="300" width="300" alt="">
                                                            @endif
                                                    </div>
                                                    <h5 class="card-title">
                                                        Ban Rusak
                                                    </h5>
                                                    
                                                    <p class="card-text">Pengaduan nomer <b>#00{{ $pengaduan->id }}</b> telah diajukan oleh <u>{{ $pengaduan->name }}</u> dan
                                                        disetujui pada tanggal {{ now()->parse($pengaduan->waktu_insiden)->translatedFormat('j F Y') }}. Unit <b>{{ $pengaduan->no_lambung }}</b> dinyatakan {{ $pengaduan->judul }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="card mb-4">
                                                <div class="card-header">
                                                    Status Ticket
                                                </div>
                                                <div class="card-body">
                                                    <div class="timeline timeline-xs">
                                                        <!-- Timeline Item 1-->
                                                        <div class="timeline-item">
                                                            <div class="timeline-item-marker">
                                                                <div class="timeline-item-marker-indicator bg-secondary"></div>
                                                            </div>
                                                            <div class="timeline-item-content">
                                                                Ticket Baru telah Dibuat!
                                                                <a class="fw-bold text-dark" href="#!">Kode #00{{ $pengaduan->id }}</a>
                                                                unit {{ $pengaduan->no_lambung }} telah di 
                                                                <span class="badge bg-danger">breakdown</span>
                                                            </div>
                                                        </div>
                                                        @if ($pengaduan->status_ticket >= 2)
                                                            <!-- Timeline Item 2-->
                                                            <div class="timeline-item">
                                                                <div class="timeline-item-marker">
                                                                    <div class="timeline-item-marker-indicator bg-primary"></div>
                                                                </div>
                                                                <div class="timeline-item-content">
                                                                    Planner telah melakukan permintaan sparepart
                                                                </div>
                                                            </div>
                                                        @endif
                                                        
                                                        @if ($pengaduan->status_ticket >= 3)
                                                        <!-- Timeline Item 3-->
                                                        <div class="timeline-item">
                                                            <div class="timeline-item-marker">
                                                                <div class="timeline-item-marker-indicator bg-success"></div>
                                                            </div>
                                                            <div class="timeline-item-content">
                                                                Logistik telah melakukan persetujuan permintaan sparepart
                                                            </div>
                                                        </div>
                                                        @endif

                                                        @if ($pengaduan->status_ticket >= 4)
                                                        <!-- Timeline Item 4-->
                                                        <div class="timeline-item">
                                                            <div class="timeline-item-marker">
                                                                <div class="timeline-item-marker-indicator bg-danger"></div>
                                                            </div>
                                                            <div class="timeline-item-content">
                                                                Mekanik telah melakukan tindakan
                                                            </div>
                                                        </div>
                                                        @endif

                                                        @if ($pengaduan->status_ticket >= 5)
                                                        <!-- Timeline Item 5-->
                                                        <div class="timeline-item">
                                                            <div class="timeline-item-marker">
                                                                <div class="timeline-item-marker-indicator bg-primary"></div>
                                                            </div>
                                                            <div class="timeline-item-content">
                                                                Planner telah menutup pengaduan
                                                            </div>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Information Tab Pane 3-->
                                <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-pill">
                                    <div class="table-responsive text-nowrap mb-3">
                                        @livewire('unit-histories', ['masterUnitId' => $pengaduan->master_unit_id])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    {{-- @livewireScripts --}}
    

    @livewire('modal-acc-logistik', ['pengaduanId' => $pengaduan->id])
    
    @livewireScripts

    @livewire('modal-acc-ho', ['pengaduanId' => $pengaduan->id]) 

    
@endsection


    


