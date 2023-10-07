import './bootstrap';
import { createApp } from 'vue';
import App from './vue/App.vue';
import router from './routes';

const app = createApp(App);
app.use(router);
app.mount("#app");