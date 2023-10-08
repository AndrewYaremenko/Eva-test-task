import './bootstrap';
import { createApp } from 'vue';
import App from './vue/App.vue';
import router from './vue/routes/routes';
import store from './vue/store/store';

const app = createApp(App);
app.use(router);
app.use(store);
app.mount("#app");