<template>
  <AdminNavComponent></AdminNavComponent>

  <div class="container">
    <div class="mt-3">
      <button @click="sortAppointments('asc')" class="btn btn-success mx-2">
        date asc
      </button>
      <button @click="sortAppointments('desc')" class="btn btn-success mx-2">
        date desc
      </button>
      <button @click="sortAppointments('service')" class="btn btn-success mx-2">
        service
      </button>
    </div>
    <div class="mt-3">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Hour</th>
            <th>Name</th>
            <th>Phone_number</th>
            <th>Service_id</th>
            <th>Salon_id</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="appointment in appointments" :key="appointment.id">
            <td>{{ appointment.id }}</td>
            <td>{{ appointment.date }}</td>
            <td>{{ appointment.hour }}</td>
            <td>{{ appointment.name }}</td>
            <td>{{ appointment.phone_number }}</td>
            <td>{{ appointment.service.id }}</td>
            <td>{{ appointment.service.salon_id }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
import AdminNavComponent from "./ui/AdminNavComponent.vue";
import axios from "axios";

export default {
  components: {
    AdminNavComponent,
  },
  data() {
    return {
      appointments: [],
    };
  },
  methods: {
    sortAppointments(sortType) {
      // Отправляем запрос на сервер с параметром sort
      axios
        .get(`/api/v1/appointments?sort=${sortType}`)
        .then((response) => {
          this.appointments = response.data.data;
        })
        .catch((error) => {
          console.error("Ошибка при получении отсортированных данных:", error);
        });
    },
  },
  mounted() {
    axios
      .get("/api/v1/appointments")
      .then((response) => {
        this.appointments = response.data.data;
      })
      .catch((error) => {
        console.error("Ошибка при получении данных:", error);
      });
  },
};
</script>