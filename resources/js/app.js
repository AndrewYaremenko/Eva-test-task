import $ from 'jquery';
import './bootstrap';
import { createApp } from 'vue';
import router from './vue/routes/routes';
import store from './vue/store/store';

window.jQuery = $;
window.$ = $;

const app = createApp();
app.use(router);
app.use(store);
app.mount("#app");