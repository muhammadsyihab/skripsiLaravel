<template>
    
    
    <slot/>

</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import { onMounted, reactive } from "vue";

export default {
    components: {
        Link
    },
    setup() {
        const App = reactive({'name': ''});
        onMounted(() => {
            App.name = process.env.MIX_APP_NAME
        });

        return {
            App
        }
    }
}

</script>
