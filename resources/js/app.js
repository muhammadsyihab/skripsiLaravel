import './bootstrap';
// import routes from './routes';
// import axios from 'axios';

// import { createApp } from 'vue';

// const app = createApp({});




// if (document.getElementById('app') != null) {
//     app.use(routes).mount('#app');
// }

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';

// import io from "socket.io-client";

// createInertiaApp.prototype.$socket = io();

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: false,
//     disableStats: true
// });

createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mount(el)
  },
})