import { createRouter, createWebHistory } from 'vue-router';
import SalonComponent from './vue/components/SalonComponent.vue';
import AppointmentComponent from './vue/components/AppointmentComponent.vue'

const routes = [
  { path: '/salon', component: SalonComponent },
  { path: '/appointment', component: AppointmentComponent },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;