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
    <div class="col-8 ps-0">
        <div class="p-0 full-height overflow-auto scrollbar-custom">
            <div v-if="$page.props.flash.success != null" class="alert alert-success" role="alert">
                {{ $page.props.flash.success }}
            </div>
            <div v-if="$page.props.flash.danger != null" class="alert alert-danger" role="alert">
                {{ $page.props.flash.danger }}
            </div>
            <div class="ps-2 pe-2 pt-2">
                <!-- Right Histories -->
                <div style="margin-bottom: 110px;">
                    <div class="row justify-content-start mb-4" v-for="(chat, index) in histories">
                        <div>
                            <div class="card">
                                <div class="card-header bg-white d-flex text-dark justify-content-between p-2 d-flex align-items-center">
                                    <div>
                                        {{ chat.user.name }} &nbsp;
                                        <span v-if="chat.user.role == 0" class="badge bg-warning">PIC</span>
                                        <span v-if="chat.user.role == 1" class="badge bg-primary">Planner</span>
                                        <span v-if="chat.user.role == 2" class="badge bg-success">Warehouse</span>
                                        <span v-if="chat.user.role == 3" class="badge bg-danger">Mechanic</span>
                                        <span v-if="chat.user.role == 4" class="badge bg-secondary">Operator</span>
                                    </div>
                                    <div>
                                        <i class="text-sm text-muted align-end">{{ dateTime(chat.created_at) }} </i>
                                    </div>
                                </div>
                                <div class="card-body p-2">
                                    <p class="text-lg-start" v-if="chat.photo == null">{{ chat.keterangan }}.</p>
                                    <div class="row" v-if="chat.photo != null">
                                        <div class="col">
                                            <p class="text-lg-start">{{ chat.keterangan }}.</p>
                                        </div>
                                        <div class="col">
                                            <div v-if="chat.photo != null" class="col-md-3 px-0">
                                                <img :src="`/storage/chat/${chat.photo}`" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- End Right Histories -->
                <!-- Action Button -->
                <div class="position-absolute top-50 end-0 translate-middle-y bg-grey">
                    
                    <!-- {{ user }} -->
                    <button v-if="user.role == 1" class="btn btn-primary" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasPlanner" aria-controls="offcanvasPlanner">
                        <i class="fas fa-clipboard pr-2"></i>&nbsp;Planner
                    </button>
                    <button v-if="user.role == 2" class="btn btn-success" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasLogistik" aria-controls="offcanvasLogistik">
                        <i class="fas fa-paper-plane pr-2"></i>&nbsp;Logistik
                    </button>
                    <button v-if="user.role == 0" class="btn btn-warning" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBoss" aria-controls="offcanvasBoss">
                        <i class="fas fa-user pr-2"></i>&nbsp;PIC
                    </button>
                </div>
            </div>
            <!-- End Action Button -->
            <div class="position-fixed bottom-0 bg-white m-0" style="width: 67%">
                <form @submit.prevent="submitChat">
                    <div class="input-group">
                        <div class="input-group-text bg-transparent border-0">
                            <input type="file" class="form-control" placeholder="Keterangan ..." ref="inputFile" name="keterangan" id="keterangan"  @input="formChat.photo = $event.target.files[0]">
                        </div>
                        <input type="text" class="form-control border-0" placeholder="Keterangan ..."
                            name="keterangan" id="keterangan" v-model="formChat.keterangan">
                        <div class="input-group-text bg-transparent border-0">
                            <button class="btn btn-light text-primary" type="submit">
                                <i class="fas fa-share"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>











 
    <div class="offcanvas offcanvas-end p-0 w-50" tabindex="-1" id="offcanvasPlanner" aria-labelledby="offcanvasPlannerLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasPlannerLabel">Planner</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body full-height overflow-auto scrollbar-custom p-0">
            <div class="card full-height overflow-auto scrollbar-custom">
                <div class="card-header border-bottom bg-white">
                    <!-- Dashboard card navigation-->
                    <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="stock-pill" href="#stock"
                                data-bs-toggle="tab" role="tab" aria-controls="stock"
                                aria-selected="true">Request Sparepart</a></li>
                        <li class="nav-item"><a class="nav-link" id="history-pill" href="#history" data-bs-toggle="tab"
                                role="tab" aria-controls="history" aria-selected="false">Tambah History Unit</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="dashboardNavContent2">
                        <div class="tab-pane fade show active" id="stock" role="tabpanel" aria-labelledby="stock-pill">
                            <form @submit.prevent="submitRequest">
                                <label for="">Sparepart</label>
                                <VueMultiselect 
                                    v-model="selectedSparepart" 
                                    :options="spareparts" 
                                    :multiple="true"
                                    :close-on-select="true"
                                    track-by="nama_item"
                                    label="nama_item"
                                    placeholder="Sparepart ..."
                                    class="mb-3"
                                />
                                <div class="mb-3" v-for="(qty, index) in selectedSparepart">
                                    <label for="">Jumlah {{ qty.nama_item }}</label>
                                    <input v-model="qty.qty_keluar" class="form-control" id="qty_keluar" type="number" :placeholder="`Jumlah...`">
                                </div>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success btn-md">Simpan</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="history" role="tabpanel" aria-labelledby="history-pill">
                            <form @submit.prevent="submitUnitHistory">
                                <div class="mb-3">
                                    <input v-model="formUnitHistory.ket_sp" class="form-control" id="qty_keluar" type="text" placeholder="Keterangan status unit ...">
                                </div>
                                <div class="mb-3">
                                    <select class="form-select" aria-label="Default select example" v-model="formUnitHistory.status_sp" placeholder="Penanggung Jawab Alat ..." >
                                        <option value="0">Ready</option>
                                        <!-- <option value="1">Dikirim</option> -->
                                        <option value="2">Breakdown</option>
                                    </select>
                                </div>
                                <VueMultiselect 
                                    v-model="selectedUserUnit" 
                                    :options="users" 
                                    :multiple="false"
                                    :close-on-select="true"
                                    track-by="name"
                                    label="name"
                                    placeholder="Penanggung Jawab Alat ..."
                                    class="mb-3"
                                />
                                
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-secondary btn-md">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>




    


    <div class="offcanvas offcanvas-end p-0 w-50" tabindex="-1" id="offcanvasLogistik" aria-labelledby="offcanvasLogistikLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasLogistikLabel">Logistik</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body full-height overflow-auto scrollbar-custom p-0">
            <div class="card full-height overflow-auto scrollbar-custom">
                <div class="card-header border-bottom bg-white">
                    <!-- Dashboard card navigation-->
                    <ul class="nav nav-tabs card-header-tabs" id="dashboardNav" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="request-pill" href="#request"
                                data-bs-toggle="tab" role="tab" aria-controls="request"
                                aria-selected="true">Daftar Request</a></li>
                        <li class="nav-item"><a class="nav-link" id="pribadi-pill" href="#pribadi" data-bs-toggle="tab"
                                role="tab" aria-controls="pribadi" aria-selected="false">Pembelian Pribadi</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="dashboardNavContent2">
                        <div class="tab-pane fade show active" id="request" role="tabpanel" aria-labelledby="request-pill">
                            <div class="table-responsive-xxl text-nowrap mb-3">
                                <table class="table table-bordered table-striped simpleDatatables" id="simpleDatatables">
                                    <thead>
                                        <tr>
                                            <th class="border-gray-200" scope="col">Tanggal Request</th>
                                            <th class="border-gray-200" scope="col">Sparepart</th>
                                            <th class="border-gray-200" scope="col">Part Number</th>
                                            <th class="border-gray-200" scope="col">Jumlah</th>
                                            <th class="border-gray-200" scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr  v-for="(request, index) in requests">
                                            <td>{{ dateTime(request.tanggal_keluar) }}</td>
                                            <td>{{ request.sparepart.nama_item }}</td>
                                            <td>{{ request.sparepart.part_number }}</td>
                                            <td>{{ request.qty_keluar }}</td>
                                            <td>                      
                                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" :href="`#acc${request.id}`">
                                                    Acc
                                                </button>&nbsp;
                                                <button type="button" class="btn btn-sm btn-danger" @click="cancelRequest(request.id)">Cancel</button>&nbsp;

                                                <div class="modal fade" :id="`acc${request.id}`" tabindex="-1" aria-labelledby="accLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="accLabel">Pembelian Pribadi</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form @submit.prevent="accRequest(request.id)">
                                                                    <label for="">Penerima</label>
                                                                    <VueMultiselect 
                                                                        v-model="selectedUser" 
                                                                        :options="users" 
                                                                        :multiple="false"
                                                                        :close-on-select="true"
                                                                        track-by="name"
                                                                        label="name"
                                                                        placeholder="Penerima ..."
                                                                        class="mb-3"
                                                                    />
                                                                    <div class="mb-3">
                                                                        <label for="">Estimasi Pengiriman (JAM)</label>
                                                                        <input v-model="formAccRequest.estimasi_pengiriman" class="form-control" id="estimasi_pengiriman" type="number" placeholder="Estimasi Pengiriman (JAM) ...">
                                                                    </div>
                                                                    
                                                                    <div class="d-grid gap-2">
                                                                        <button type="submit" class="btn btn-success btn-md">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- <tr v-for="(sparepart, index) in requests">
                                            <td>{{ dateTime(sparepart.tanggal_keluar) }}</td>
                                            <td>{{ sparepart.sparepart.nama_item }} {{ sparepart.id }}</td>
                                            <td>{{ sparepart.sparepart.part_number }}</td>
                                            <td>{{ sparepart.qty_keluar  }} {{ sparepart.sparepart.uom }}</td>
                                            <td>                      
                                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal" :href="`#acc${sparepart.id}`">
                                                    Acc
                                                </button>&nbsp;
                                                <button type="button" class="btn btn-sm btn-danger">Cancel</button>&nbsp;

                                                <div class="modal fade" :id="`acc${sparepart.id}`" tabindex="-1" aria-labelledby="accLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="accLabel">Pembelian Pribadi</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form @submit.prevent="accRequest(sparepart.id)">
                                                                    <label for="">Penerima</label>
                                                                    <VueMultiselect 
                                                                        v-model="selectedUser" 
                                                                        :options="users" 
                                                                        :multiple="false"
                                                                        :close-on-select="true"
                                                                        track-by="name"
                                                                        label="name"
                                                                        placeholder="Penerima ..."
                                                                        class="mb-3"
                                                                    />
                                                                    <div class="mb-3">
                                                                        <label for="">Estimasi Pengiriman (JAM)</label>
                                                                        <input v-model="formAccRequest.estimasi_pengiriman" class="form-control" id="estimasi_pengiriman" type="number" placeholder="Estimasi Pengiriman (JAM) ...">
                                                                    </div>
                                                                    
                                                                    <div class="d-grid gap-2">
                                                                        <button type="submit" class="btn btn-success btn-md">Simpan</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-primary">Save changes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pribadi" role="tabpanel" aria-labelledby="pribadi-pill">
                            <form @submit.prevent="submitRequestKosong">
                                <label for="">Pembeli</label>
                                <VueMultiselect 
                                    v-model="selectedUserPembeli" 
                                    :options="users" 
                                    :multiple="false"
                                    :close-on-select="true"
                                    track-by="name"
                                    label="name"
                                    placeholder="Pembeli ..."
                                    class="mb-3"
                                />
                                <label for="">Penerima</label>
                                <VueMultiselect 
                                    v-model="selectedUserPenerima" 
                                    :options="users" 
                                    :multiple="false"
                                    :close-on-select="true"
                                    track-by="name"
                                    label="name"
                                    placeholder="Penerima ..."
                                    class="mb-3"
                                />
                                <div class="mb-3">
                                    <label for="">Part Number</label>
                                    <input v-model="formRequestKosong.part_number" class="form-control" id="qty_keluar" type="text" :placeholder="`Part Number ...`">
                                </div>
                                <div class="mb-3">
                                    <label for="">Nama Item</label>
                                    <input v-model="formRequestKosong.nama_item" class="form-control" id="qty_keluar" type="text" :placeholder="`Nama Item ...`">
                                </div>
                                <div class="mb-3">
                                    <label for="">UOM</label>
                                    <input v-model="formRequestKosong.uom" class="form-control" id="qty_keluar" type="text" :placeholder="`UOM ...`">
                                </div>
                                <div class="mb-3">
                                    <label for="">Quantity</label>
                                    <input v-model="formRequestKosong.qty" class="form-control" id="estimasi_pengiriman" type="number" placeholder="QTY ...">
                                </div>
                                <div class="mb-3">
                                    <label for="">item Price</label>
                                    <input v-model="formRequestKosong.item_price" class="form-control" id="estimasi_pengiriman" type="number" placeholder="Item Price ...">
                                </div>
                                <div class="mb-3">
                                    <label for="">Estimasi</label>
                                    <input v-model="formRequestKosong.estimasi" class="form-control" id="estimasi_pengiriman" type="number" placeholder="Estimasi ...">
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success btn-md">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>









    <div class="offcanvas offcanvas-end w-50" tabindex="-1" id="offcanvasBoss" aria-labelledby="offcanvasBossLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasLogistikLabel">PIC</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body full-height overflow-auto scrollbar-custom">
            <div class="table-responsive table-responsive-xxl text-nowrap mb-3">
                <table class="table table-striped table-bordered simpleDatatables" id="simpleDatatables">
                    <thead>
                        <tr>
                            <th class="border-gray-200" scope="col">Tanggal Request</th>
                            <th class="border-gray-200" scope="col">Sparepart</th>
                            <th class="border-gray-200" scope="col">Part Number</th>
                            <th class="border-gray-200" scope="col">Jumlah</th>
                            <th class="border-gray-200" scope="col">Item Price</th>
                            <th class="border-gray-200" scope="col">Amount</th>
                            <th class="border-gray-200" scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- {{  requestPribadi  }} -->
                        <tr v-for="(request, index) in requestPribadi">
                            <td>{{ dateTime(request.tanggal_keluar) }}</td>
                            <td>{{ request.nama_item }}</td>
                            <td>{{ request.part_number }}</td>
                            <td>{{ request.qty }} {{ request.uom }}</td>
                            <td>{{ format(request.item_price) }}</td>
                            <td>{{ format(request.amount) }}</td>
                            <td>                   
                                <form @submit.prevent="accRequestPrb(request.id)">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        Acc
                                    </button>&nbsp;
                                    <button type="button" class="btn btn-sm btn-danger" @click="cancelRequestPrb(request.id)">Cancel</button>&nbsp;
                                </form>
                            </td>
                        </tr>
                        <!-- <tr v-for="(sparepart, index) in requestPribadi">
                            <td>{{ dateTime(sparepart.tanggal_keluar) }}</td>
                            <td>{{ sparepart.nama_item }} {{ sparepart.id }}</td>
                            <td>{{ sparepart.part_number }}</td>
                            <td>{{ sparepart.qty }} {{ sparepart.uom }}</td>
                            <td>{{ format(sparepart.item_price) }}</td>
                            <td>{{ format(sparepart.amount) }}</td>
                            <td>                   
                                <form @submit.prevent="accRequestPrb(sparepart.id)">
                                    <button type="submit" class="btn btn-sm btn-success">
                                        Acc
                                    </button>&nbsp;
                                </form>
                            </td>
                        </tr> -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>


</template>
<!-- <script src="https://cdn.socket.io/4.5.4/socket.io.min.js" integrity="sha384-/KNQL8Nu5gCHLqwqfQjA689Hhoqgi2S84SNUxC3roTe4EhJ9AfLkp8QiQcU8AMzI" crossorigin="anonymous"></script> -->

<script>
    import { onMounted, ref, reactive } from "vue";
    import moment from "moment";
    import { Inertia } from '@inertiajs/inertia';
    import { useForm } from "@inertiajs/inertia-vue3";
    import VueMultiselect from 'vue-multiselect';
    import "bootstrap";
    import $ from "jquery";
    import "datatables.net-bs5";
    import io from "socket.io-client";

    export default {
        components: {
            VueMultiselect
        },
        props: {
            histories: Object,
            hTicket: Object,
            hUnit: Object,
            users: Object,
            user: Object,
            spareparts: Object,
            requests: Object,
            requestPribadi: Object,
        },
        data () {
            return {
                options: ['list', 'of', 'options']
            }
        },
        setup(props) {
            const selectedUser = ref(null);
            const selectedUserUnit = ref(null);
            const selectedSparepart = ref(null);
            const selectedUserPenerima = ref(null);
            const selectedUserPembeli = ref(null);

            // pas dibuka
            onMounted(() => {
                $('.simpleDatatables').DataTable();

                let socket = io('https://live.etambang.my.id');
                socket.on('connection');
            });

            // chat
            const formChat = useForm({
                tb_tiketing_id: props.hTicket.id,
                keterangan: '',
                photo: null,
            });

            function submitChat(e) {
                Inertia.post('/admin/ticketVue/history', formChat);
                formChat.reset();
                $event.target.files[0] = null;
            }

            // post history unit
            const formUnitHistory = useForm({
                master_unit_id: props.hTicket.master_unit_id,
                ket_sp: '',
                status_sp: '',
                pj_alat: '',
            });

            function submitUnitHistory(e) {

                formUnitHistory.pj_alat = this.selectedUserUnit.name;
                Inertia.post('/admin/ticketVue/history/unit', formUnitHistory);
                formChat.reset();
            }

            // request planner ke logistik
            
            // stock ada
            const qty_keluar = ref([]);
            const formRequest = useForm({
                master_unit_id: props.hUnit.id,
                master_lokasi_id: props.hUnit.lokasi.id,
                master_sparepart_id: 0,
                tb_tiketing_id: props.hTicket.id,
                qty_keluar: 0,
                status: 0,
                penerima: 0,
                hm_odo: '',
                tanggal_keluar: '',
                estimasi_pengiriman: null,
                photo: '',
            });

            function submitRequest() {
                formRequest.status = 0;
                
                formRequest.qty_keluar = JSON.stringify(this.selectedSparepart);
                Inertia.post('/admin/ticketVue/request', formRequest);
                formRequest.reset();
            }

            // Acc Request
            const formAccRequest = useForm({
                tb_tiketing_id: props.hTicket.id,
                status: 1,
                penerima: 0,
                estimasi_pengiriman: null,
            });

            function accRequest(id) {
                formAccRequest.penerima = this.selectedUser.id;
                console.log([formAccRequest, id]);
                Inertia.put(`/admin/ticketVue/request/${id}/acc`, formAccRequest);
                formAccRequest.reset();
            }

            // cancel Request
            const formCancelRequest = useForm({
                tb_tiketing_id: props.hTicket.id
            });

            function cancelRequest(id) {
                Inertia.put(`/admin/ticketVue/request/${id}/cancel`, formCancelRequest);
            }

            //stock tidak ada
            const formRequestKosong = useForm({
                master_unit_id: props.hUnit.id,
                tb_tiketing_id: props.hTicket.id,
                part_number: '',
                nama_item: '',
                qty: null,
                item_price: null,
                amount: null,
                uom: null,
                status: 0,
                pembeli: 0,
                penerima: 0,
                tanggal_keluar: '',
                estimasi: null,
                photo: null,
            });

            function submitRequestKosong() {
                formRequestKosong.pembeli = this.selectedUserPembeli.id;
                formRequestKosong.penerima = this.selectedUserPenerima.id;
                Inertia.post('/admin/ticketVue/request/kosong', formRequestKosong);
                formRequestKosong.reset();
                this.selectedUserPembeli = null;
                this.selectedUserPenerima = null;
            }

            // Acc pembelian pribadi
            const formAccRequestPrb = useForm({
                tb_tiketing_id: props.hTicket.id,
            });

            function accRequestPrb(id) {
                Inertia.put(`/admin/ticketVue/prb/${id}/acc`, formAccRequest);
            }

            // cancel pembelian pribadi
            const formCancelRequestPrb = useForm({
                tb_tiketing_id: props.hTicket.id,
            });

            function cancelRequestPrb(id) {
                Inertia.put(`/admin/ticketVue/prb/${id}/cancel`, formCancelRequestPrb);
            }

            return { 
                formChat, 
                formRequest, 
                formUnitHistory, 
                formRequestKosong, 
                formAccRequest, 
                submitChat,
                submitRequest,
                submitUnitHistory,
                submitRequestKosong,
                accRequest,
                accRequestPrb,
                cancelRequest,
                cancelRequestPrb,
                selectedUser,
                selectedSparepart,
                selectedUserUnit,
                selectedUserPembeli,
                selectedUserPenerima,
                qty_keluar,
            }
        },
        methods: {
            dateTime(value) {
                return moment(value).format('D MMMM YYYY, h:mm a');
            },
            format(value) {
                var formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR'
                });

                return formatter.format(value);
            }
        }
    }
</script>

<style src="vue-multiselect/dist/vue-multiselect.css"></style>