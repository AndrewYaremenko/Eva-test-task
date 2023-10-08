import { createRouter, createWebHistory } from 'vue-router';
import SalonComponent from '../components/SalonComponent.vue';
import AppointmentComponent from '../components/AppointmentComponent.vue'
import AdminComponent from '../components/admin/AdminComponent.vue'
import AdminSalonComponent from '../components/admin/AdminSalonComponent.vue'
import AdminServiceComponent from '../components/admin/AdminServiceComponent.vue'
import AdminAppointmentComponent from '../components/admin/AdminAppointmentComponent.vue'

const routes = [
  { path: '/salon', component: SalonComponent, meta: { title: 'Salon' } },
  { path: '/appointment', component: AppointmentComponent, meta: { title: 'Appointment' } },
  { path: '/admin', component: AdminComponent, meta: { title: 'admin' } },
  { path: '/admin/salons', component: AdminSalonComponent, meta: { title: 'admin' } },
  { path: '/admin/services', component: AdminServiceComponent, meta: { title: 'admin' } },
  { path: '/admin/appointments', component: AdminAppointmentComponent, meta: { title: 'admin' } },
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