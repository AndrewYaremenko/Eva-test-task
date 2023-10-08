<template>
  <div class="container col-md-4 offset-md-4 mt-4">
    <div v-if="!selectedSalon && !selectedService">
      <h1 class="mb-4">Оберіть салон та послугу</h1>
      <router-link to="/salon">Перейти на сторінку вибору салону</router-link>
    </div>
    <div v-if="selectedSalon && selectedService">
      <div class="form-inline">
        <h1 class="mb-4">Запис на прийом</h1>
        <label>Виберіть дату:</label>
        <div>
          <VueDatePicker
            v-model="date"
            :min-date="new Date()"
            :disabled-week-days="[0]"
            :enable-time-picker="false"
            auto-apply
            @update:model-value="loadAvailableHours"
            @cleared="cleared"
            class="form-group mb-3"
          ></VueDatePicker>
        </div>

        <div v-if="date" class="form-group mb-3">
          <label>Виберіть годину:</label>
          <select
            v-model="selectedHour"
            class="form-control"
            :disabled="availableHours.length === 0"
          >
            <option v-if="isFirstRequestForHours" value="" disabled selected>
              Зачекайте
            </option>
            <option
              v-if="availableHours.length > 0 && !isFirstRequestForHours"
              value=""
              disabled
              selected
            >
              Виберіть годину
            </option>
            <option
              v-if="availableHours.length === 0 && !isFirstRequestForHours"
              value=""
              disabled
              selected
            >
              Немає вільних годин
            </option>
            <option v-for="hour in availableHours" :key="hour" :value="hour">
              {{ hour }}:00
            </option>
          </select>
        </div>

        <div v-if="selectedHour">
          <button @click="openModal" class="btn btn-primary">
            Зробити запис
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" id="modal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" v-if="date && selectedHour">
            Запис на прийом
          </h5>
          <button
            type="button"
            class="btn btn-danger"
            @click="isSuccessfulRequest ? successfulClose() : closeModal()"
          >
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form v-if="!isSuccessfulRequest">
            <div class="form-group">
              <label for="name">Ім'я:</label>
              <input
                type="text"
                class="form-control"
                id="name"
                v-model="name"
              />
              <div v-if="errors && errors.name" class="text-danger">
                {{ errors.name }}
              </div>
            </div>
            <div class="form-group">
              <label for="phone">Номер телефону:</label>
              <input
                type="text"
                class="form-control"
                id="phone"
                v-model="phone"
              />
              <div v-if="errors && errors.phone" class="text-danger">
                {{ errors.phone }}
              </div>
            </div>
          </form>
          <div v-if="isSuccessfulRequest">
            {{ formatDate(date) }} {{ selectedHour }}:00<br />
            {{ selectedService.name }}<br />
            {{ selectedSalon.address }}
          </div>
        </div>
        <div class="modal-footer">
          <button
            @click="isSuccessfulRequest ? successfulClose() : makeAppointment()"
            class="btn btn-primary"
          >
            {{ isSuccessfulRequest ? "ОК" : "Записатися" }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import axios from "axios";
import { mapGetters } from "vuex";

export default {
  components: { VueDatePicker },
  data() {
    return {
      date: null,
      selectedHour: "",
      availableHours: [],
      name: "",
      phone: "",
      isSuccessfulRequest: false,
      isFirstRequestForHours: true,
      errors: {},
    };
  },
  methods: {
    loadAvailableHours() {
      if (!this.date) return;

      const serviceId = this.selectedService.id;
      const formattedDate = this.formatDate(this.date);
      this.selectedHour = "";

      axios
        .get("/api/appointments/hours/free", {
          params: {
            id: serviceId,
            date: formattedDate,
          },
        })
        .then((response) => {
          this.availableHours = response.data.freeHours;
          this.isFirstRequestForHours = false;
        })
        .catch((error) => {
          console.error("Error during upload free hours", error);
        });
    },

    cleared() {
      this.selectedHour = "";
    },

    formatDate(date) {
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, "0");
      const day = String(date.getDate()).padStart(2, "0");
      return `${year}-${month}-${day}`;
    },

    openModal() {
      this.errors = null;
      $("#modal").modal("show");

      $("#modal").on("hidden.bs.modal", this.handleModalClose);
    },
    closeModal() {
      $("#modal").modal("hide");
    },
    makeAppointment() {
      axios
        .post("/api/appointments", {
          service_id: parseInt(this.selectedService.id),
          date: this.formatDate(this.date),
          hour: parseInt(this.selectedHour),
          name: this.name,
          phone_number: this.phone,
        })
        .then((response) => {
          this.errors = null;
          this.isSuccessfulRequest = true;
        })
        .catch((error) => {
          if (error.response.status === 422) {
            this.errors = {
              name: error.response.data.errors.name
                ? "Потрібно ввести ім'я"
                : "",
              phone: error.response.data.errors.phone_number
                ? "Потрібно ввести номер телефону"
                : "",
            };
          } else {
            console.error("Error during create appointment", error);
          }
        });
    },

    successfulClose() {
      $("#modal").modal("hide");
      this.$router.push({
        path: "/salon",
      });
    },
    handleModalClose() {
      if (this.isSuccessfulRequest) {
        $("#modal").modal("hide");
        this.$router.push({
          path: "/salon",
        });
      }
    },
  },
  computed: {
    ...mapGetters(["selectedSalon", "selectedService"]),
  },
};
</script>
