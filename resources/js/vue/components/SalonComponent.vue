<template>
  <div class="container col-md-4 offset-md-4 mt-4">
    <h1 class="mb-4">Вибір салону та послуги</h1>
    <form class="form-inline">
      <div class="form-group mb-3">
        <label for="salon">Виберіть салон:</label>
        <select
          class="form-control"
          v-model="selectedSalon"
          @change="loadServices"
        >
          <option value="">Виберіть салон</option>
          <option v-for="salon in salons" :value="salon" :key="salon.id">
            {{ salon.name }} | {{ salon.address }}
          </option>
        </select>
      </div>

      <div class="form-group mb-3">
        <label for="service">Виберіть послугу:</label>
        <select class="form-control" v-model="selectedService">
          <option value="">Виберіть послугу</option>
          <option
            v-for="service in services"
            :value="service"
            :key="service.id"
          >
            {{ service.name }}
          </option>
        </select>
      </div>

      <button
        @click="goToBookingPage"
        :disabled="!selectedSalon || !selectedService"
        class="btn btn-primary"
      >
        Далі
      </button>
    </form>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "SalonComponent",
  data() {
    return {
      selectedSalon: "",
      selectedService: "",
      salons: [],
      services: [],
    };
  },
  methods: {
    async loadSalons() {
      try {
        const response = await axios.get("/api/salons");
        this.salons = response.data.data;
      } catch (error) {
        console.error("Ошибка при загрузке салонов", error);
      }
    },
    loadServices() {
      this.selectedService = "";
      this.services = this.selectedSalon.services;
    },
    goToBookingPage() {
      this.$router.push({
        path: "/appointment",
        query: {
          serviceId: this.selectedService.id,
        },
      });
    },
  },
  async mounted() {
    await this.loadSalons();
  },
};
</script>
