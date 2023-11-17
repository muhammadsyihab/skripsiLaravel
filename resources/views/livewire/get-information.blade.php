
<div>


    <div class="card">
        <div class="card-header border-bottom bg-white">
            <!-- Dashboard card navigation-->
            <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="information-pill" href="#information"
                        data-bs-toggle="tab" role="tab" aria-controls="information"
                        aria-selected="true">Informasi</a></li>
                <li class="nav-item"><a class="nav-link" id="timeline-pill" href="#timeline" data-bs-toggle="tab"
                        role="tab" aria-controls="timeline" aria-selected="false">Riwayat Unit</a></li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="dashboardNavContent">
                <!-- Information Tab Pane 1-->
                <div class="tab-pane fade show active" id="information" role="tabpanel"
                    aria-labelledby="information-pill">
                    <div class="accordion mb-4" id="accordionTicket">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-center">
                                    <img src="{{ asset('storage/camera_default.png') }}" height="300" width="300" alt=""
                                        class="">
                                </div>

                                <h5 class="card-title">

                                    Ban Rusak
                                </h5>
                                <p class="card-text">Pengaduan nomer <b>#1231</b> telah diajukan oleh <u>Ahmad Murteza Akbari</u> dan
                                    disetujui pada tanggal 12 februari 2023. Unit <b>EST DT-86/SANY SKT 80S</b> dinyatakan Ban Rusak di
                                    710 HM/KM</p>
                            </div>
                        </div>
                    </div>
                    <div class="card h-100 mb-4">
                        <div class="card-header">
                            Status Ticket
                        </div>
                        <div class="card-body">
                            <div class="timeline timeline-xs">
                                <!-- Timeline Item 1-->
                                <div class="timeline-item" v-if="ticket.status_ticket >= 0">
                                    <div class="timeline-item-marker">
                                        <div class="timeline-item-marker-text">27 min</div>
                                        <div class="timeline-item-marker-indicator bg-primary"></div>
                                    </div>
                                    <div class="timeline-item-content">
                                        Ticket Baru telah Dibuat!
                                        <a class="fw-bold text-dark" href="#!">Kode #001</a>
                                        unit CN001 telah di 
                                        <span class="badge bg-danger">breakdown</span>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Information Tab Pane 2-->
                <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-pill">
                    <div class="table-responsive text-nowrap mb-3">
                        <div class="card h-100">
                            <div class="card-header bg-transparent">
                                <span class="badge bg-primary-soft text-primary rounded-pill py-2 px-3 mb-2">Individual</span>
                                <div class="pricing-columns-price">
                                    $9
                                    <span>/month</span>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <i class="text-primary me-2" data-feather="check-circle"></i>
                                        1 user account
                                    </li>
                                    <li class="list-group-item">
                                        <i class="text-danger me-2" data-feather="check-circle"></i>
                                        Remove ads
                                    </li>
                                    <li class="list-group-item">
                                        <i class="text-primary me-2" data-feather="check-circle"></i>
                                        Premium assets
                                    </li>
                                    <li class="list-group-item">
                                        <i class="text-primary me-2" data-feather="check-circle"></i>
                                        Saved projects
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

   
</div>
