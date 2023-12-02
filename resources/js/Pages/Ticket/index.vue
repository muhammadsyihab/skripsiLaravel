
<template>
    <AppLayout>
        <!-- asdas
        <div style="height:600px; width:800px">
            <l-map ref="map" v-model:zoom="zoom" :center="[47.41322, -1.219482]">
                <l-tile-layer
                    url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                    layer-type="base"
                    name="OpenStreetMap"
                ></l-tile-layer>
            </l-map>
        </div> -->
        <div class="row">
            <!-- <div v-if="usePage().props.value.flash" class="alert alert-info" role="alert">
                {{ $page.props.flash.message }}
            </div> -->

            <!-- <div v-if="flash.error" class="alert alert-info" role="alert">
                {{ flash.error }}
            </div>
            <div v-if="flash.message" class="alert alert-danger" role="alert">
                {{ flash.message }}
            </div> -->

            

            <informationVue :ticket="ticket" :unit="unit" :unitHistories="unitHistories" :iUser="user" ></informationVue>
            <historiesVue 
            :histories="histories" 
            :hTicket="ticket" 
            :hUnit="unit" 
            :users="users" 
            :user="user" 
            :spareparts="spareparts" 
            :requests="requests"
            :requestPribadi="requestPribadi">
            </historiesVue>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from "../../Layouts/App";
import informationVue from "./panel/information.vue";
import historiesVue from "./panel/histories.vue";
import { Head, Link, usePage } from "@inertiajs/inertia-vue3";
import Multiselect from 'vue-multiselect';
import { ref } from "vue";
import "leaflet/dist/leaflet.css";
import { LMap, LTileLayer } from "@vue-leaflet/vue-leaflet";

export default {
    components: {
        AppLayout, Head, Link, informationVue, historiesVue, Multiselect, LMap, LTileLayer,
    },
    props: {
        ticket: Object,
        unit: Object,
        unitHistories: Object,
        histories: Object,
        users: Object,
        spareparts: Object,
        requests: Object,
        requestPribadi: Object,
        user: Object,
    },
    data() {
        return {
            zoom: 16,
        };
    }
}
</script>
