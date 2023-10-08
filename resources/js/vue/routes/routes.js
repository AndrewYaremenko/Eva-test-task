import { createRouter, createWebHistory } from 'vue-router';
import SalonComponent from '../components/SalonComponent.vue';
import AppointmentComponent from '../components/AppointmentComponent.vue'

const routes = [
  { path: '/salon', component: SalonComponent, meta: { title: 'Salon' } },
  { path: '/appointment', component: AppointmentComponent, meta: { title: 'Appointment' } },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  document.title = to.meta.title;
  next();
});

export default router;