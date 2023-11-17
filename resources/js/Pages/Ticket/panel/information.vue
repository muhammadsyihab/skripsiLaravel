<style scoped>
    .full-height {
        height: calc(100vh - 3.625rem);
    }

    .scrollbar-custom::-webkit-scrollbar {
        width: 0.75rem;
    }

    .scrollbar-custom::-webkit-scrollbar-thumb {
        border-radius: 10rem;
        border-width: 0.2rem;
        border-style: solid;
        background-clip: padding-box;
        background-color: rgba(33, 40, 50, 0.2);
        border-color: transparent;
    }

    .scrollbar-custom::-webkit-scrollbar-button {
        width: 0;
        height: 0;
        display: none;
    }

    .scrollbar-custom::-webkit-scrollbar-corner {
        background-color: transparent;
    }

    .scrollbar-custom::-webkit-scrollbar-track {
        background: inherit;
    }
</style>
<template>
    <div class="col-4 p-0">
        <!-- Tabbed dashboard card example-->
        <div class="card full-height overflow-auto scrollbar-custom">
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
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingTicket">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseTicket" aria-expanded="false"
                                        aria-controls="flush-collapseTicket">
                                        <i class="me-2 text-primary" data-feather="archive"></i> Ticket 
                                    </button>
                                </h2>
                                <div id="flush-collapseTicket" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingTicket" data-bs-parent="#accordionTicket">
                                    <div class="accordion-body p-0">
                                        <div class="list-group list-group-flush small">
                                            <ul class="list-group list-group-flush small">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <i class="fas fa-credit-card text-primary me-2"></i>
                                                        Status ticket
                                                    </div>
                                                    <span v-if="ticket.status_ticket == 0" class="badge bg-secondary">Ticket Dibuat</span>
                                                    <span v-if="ticket.status_ticket == 1" class="badge bg-secondary">Analisa Mekanik</span>
                                                    <span v-if="ticket.status_ticket == 2" class="badge bg-secondary">Laporan Mekanik</span>
                                                    <span v-if="ticket.status_ticket == 3" class="badge bg-secondary">Proses Planner</span>
                                                    <span v-if="ticket.status_ticket == 4" class="badge bg-secondary">Tindakan Planner</span>
                                                    <span v-if="ticket.status_ticket == 5" class="badge bg-secondary">Proses Logistik</span>
                                                    <span v-if="ticket.status_ticket == 6" class="badge bg-secondary">Tindakan Logistik</span>
                                                    <span v-if="ticket.status_ticket == 7" class="badge bg-secondary">Proses GL</span>
                                                    <span v-if="ticket.status_ticket == 8" class="badge bg-secondary">Implementasi Mekanik</span>
                                                    <span v-if="ticket.status_ticket == 9" class="badge bg-secondary">Selesai</span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <i class="fas fa-user text-primary me-2"></i>
                                                        Pembuat ticket adalah ({{ ticket.pembuat.name }})
                                                    </div>
                                                    <div class="text-muted">{{ dateTime(ticket.waktu_insiden) }}</div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <i class="fas fa-calendar text-primary me-2"></i>
                                                        Insiden unit ({{ ticket.judul }})
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>    
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="flush-headingUnit">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseUnit" aria-expanded="false"
                                        aria-controls="flush-collapseUnit">
                                        <i class="me-2 text-secondary" data-feather="truck"></i> Unit
                                    </button>
                                </h2>
                                <div id="flush-collapseUnit" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingUnit" data-bs-parent="#accordionTicket">
                                    <div class="accordion-body p-0">
                                        <div class="list-group list-group-flush small">
                                            <ul class="list-group list-group-flush small">
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <i class="fas fa-truck-monster text-secondary me-2"></i>
                                                        Status unit
                                                    </div>
                                                    <span v-if="unit.status_unit == 1" class="badge bg-primary">WORKING</span>
                                                    <span v-if="unit.status_unit == 2" class="badge bg-secondary">STAND BY</span>
                                                    <span v-if="unit.status_unit == 3" class="badge bg-danger">BREAKDOWN</span>
                                                </li> 
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <i class="fas fa-list-ol text-secondary me-2"></i>
                                                        Nama unit ({{ unit.jenis }})
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <i class="fas fa-barcode text-secondary me-2"></i>
                                                        Nomer Lambung ({{ unit.no_lambung }})
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <i class="fas fa-clock text-secondary me-2"></i>
                                                        HM ({{ unit.total_hm }})
                                                    </div>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <i class="fas fa-compass text-secondary me-2"></i>
                                                        Lokasi unit ({{ unit.lokasi_unit }})
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>  
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item" v-if="ticket.photo">
                                <h2 class="accordion-header" id="flush-headingLokasi">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#flush-collapseLokasi" aria-expanded="false"
                                        aria-controls="flush-collapseLokasi">
                                        <i class="me-2 text-secondary" data-feather="map"></i> Foto Insiden
                                    </button>
                                </h2>
                                <div id="flush-collapseLokasi" class="accordion-collapse collapse"
                                    aria-labelledby="flush-headingLokasi" data-bs-parent="#accordionTicket">
                                    <div class="accordion-body p-0">
                                        <div class="list-group list-group-flush small">
                                            <div style="height: 300px; width: 100%">
                                                <!-- <l-map ref="map" v-model:zoom="zoom" :center="[47.41322, -1.219482]">
                                                    <l-tile-layer
                                                        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                                                        layer-type="base"
                                                        name="OpenStreetMap"
                                                    ></l-tile-layer>
                                                </l-map> -->
                                                <img :src="`/storage/tiketPhoto/${ticket.photo}`" class="img-fluid" style="height: 300px; width: 100%">
                                            </div>
                                        </div>  
                                    </div>
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
                                            <a class="fw-bold text-dark" href="#!">Kode #00{{ ticket.id }}</a>
                                            unit {{ unit.no_lambung }} telah di 
                                            <span class="badge bg-danger">breakdown</span>
                                        </div>
                                    </div>
                                    <!-- Timeline Item 2-->
                                    <div class="timeline-item" v-if="ticket.status_ticket >= 1">
                                        <div class="timeline-item-marker">
                                            <div class="timeline-item-marker-text">58 min</div>
                                            <div class="timeline-item-marker-indicator bg-primary"></div>
                                        </div>
                                        <div class="timeline-item-content">
                                            Planner telah menentukan prioritas pengaduan
                                        </div>
                                    </div>
                                    <!-- Timeline Item 3-->
                                    <div class="timeline-item" v-if="ticket.status_ticket >= 2 ">
                                        <div class="timeline-item-marker">
                                            <div class="timeline-item-marker-text">2 hrs</div>
                                            <div class="timeline-item-marker-indicator bg-primary"></div>
                                        </div>
                                        <div class="timeline-item-content">
                                            Request sparepart
                                        </div>
                                    </div>
                                    <!-- Timeline Item 4-->
                                    <div class="timeline-item" v-if="ticket.status_ticket >= 3">
                                        <div class="timeline-item-marker">
                                            <div class="timeline-item-marker-text">1 day</div>
                                            <div class="timeline-item-marker-indicator bg-success"></div>
                                        </div>
                                        <div class="timeline-item-content">
                                            Pengiriman sparepart
                                        </div>
                                    </div>
                                    <!-- Timeline Item 5-->
                                    <div class="timeline-item" v-if="ticket.status_ticket >= 4">
                                        <div class="timeline-item-marker">
                                            <div class="timeline-item-marker-text">2 days</div>
                                            <div class="timeline-item-marker-indicator bg-danger"></div>
                                        </div>
                                        <div class="timeline-item-content">
                                            Pemasangan oleh mekanik
                                        </div>
                                    </div>
                                    <!-- Timeline Item 8-->
                                    <div class="timeline-item" v-if="ticket.status_ticket >= 5">
                                        <div class="timeline-item-marker">
                                            <div class="timeline-item-marker-text">2 days</div>
                                            <div class="timeline-item-marker-indicator bg-secondary"></div>
                                        </div>
                                        <div class="timeline-item-content">
                                            Ground Test oleh operator
                                        </div>
                                    </div>
                                    <!-- Timeline Item 12-->
                                    <div class="timeline-item" v-if="ticket.status_ticket >= 6">
                                        <div class="timeline-item-marker">
                                            <div class="timeline-item-marker-text">2 days</div>
                                            <div class="timeline-item-marker-indicator bg-primary"></div>
                                        </div>
                                        <div class="timeline-item-content">
                                            Planner Memutuskan Laporan Kerusakan Selesai
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between" v-if="iUser.role == 1">
                            <form @submit.prevent="ulangTiket(ticket.id)">
                                <button type="submit" class="btn btn-secondary btn-md">Ulang Pengaduan</button>
                            </form>
                            <form @submit.prevent="tutupTicket(ticket.id)">
                                <button type="submit" class="btn btn-success btn-md">Tutup Pengaduan</button>
                            </form>
                        </div>
                        <div class="d-grid gap-2 mt-5">
                            <button class="btn btn-primary" type="button"  @click="refresh()">Segarkan</button>
                        </div>
                    </div>
                    <!-- Information Tab Pane 2-->
                    <div class="tab-pane fade" id="timeline" role="tabpanel" aria-labelledby="timeline-pill">
                        <div class="table-responsive text-nowrap mb-3">
                            <table class="table table-striped table-bordered" id="simpleDatatables">
                                <thead>
                                    <tr>
                                        <th class="border-gray-200" scope="col">Date</th>
                                        <th class="border-gray-200" scope="col">Nomer Lambung</th>
                                        <th class="border-gray-200" scope="col">Penanggung Jawab</th>
                                        <th class="border-gray-200" scope="col">Keterangan</th>
                                        <th class="border-gray-200" scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(history, index) in unitHistories">
                                        <td>{{ dateTime(history.created_at) }}</td>
                                        <td>{{ history.unit.no_lambung }}</td>
                                        <td>{{ history.pj_alat }}</td>
                                        <td>{{ history.ket_sp }}</td>
                                        <td>
                                            <span v-if="history.status_sp == 0" class="badge bg-secondary">Ready</span>
                                            <span v-if="history.status_sp == 1" class="badge bg-primary">Working</span>
                                            <span v-if="history.status_sp == 2" class="badge bg-danger">Breakdown</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import { onMounted, ref } from "vue";
    import moment from "moment";
    import { Inertia } from "@inertiajs/inertia";
    import { useForm } from "@inertiajs/inertia-vue3";
    import $ from "jquery";
    import "datatables.net-bs5";
    import "leaflet/dist/leaflet.css";
    import { latLng } from "leaflet";
    import { LMap, LTileLayer, LMarker, LPopup, LTooltip } from "@vue-leaflet/vue-leaflet";

    export default {
        components: {
            LMap, LTileLayer, LMarker, LPopup, LTooltip
        },
        props: {
            ticket: Object,
            unit: Object,
            unitHistories: Object,
            iUser: Object
        },
        data() {
            return {
                zoom: 16,
            };
        },
        setup(props) {
            
            // pas dibuka
            onMounted(() => {
                $('#simpleDatatables').DataTable();
            });

            // let zoom = 16;
            // let latlong = props.ticket.latlong.split(",");
            // let marker = props.ticket.latlong.split(",");
            // let attribution = `&copy; <a target="_blank" href="http://osm.org/copyright">OpenStreetMap</a> contributors`;
            // let url = `https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}.png`;
            // Ulang Ticket

            function ulangTiket(id) {
                Inertia.put(`/admin/ticketVue/ulang/${id}`);
            }

            // cancel pembelian pribadi
            const tutup = useForm({
                unit_id: props.unit.id,
            });

            function tutupTicket(id) {
                Inertia.put(`/admin/ticketVue/tutup/${id}`, tutup);
            }

            function refresh() {
                Inertia.post(`/admin/ticketVue/refresh`);
            }

            return {
                ulangTiket,
                tutupTicket,
                refresh,
                // zoom,
                // attribution,
                // url,
                // latlong,
                // marker,
            }

        },
        methods: {
            dateTime(value) {
                return moment(value).format('D MMMM YYYY, h:mm a');
            },

            format(value) {
                var formatter = new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'IND'
                });

                return formatter.format(value);

                
            },
            zoomUpdate(zoom) {
                this.currentZoom = zoom;
            },
            centerUpdate(center) {
                this.currentCenter = center;
            },
            showLongText() {
                this.showParagraph = !this.showParagraph;
            },
            innerClick() {
                alert("Click!");
            }
            
        }
    }
</script>
