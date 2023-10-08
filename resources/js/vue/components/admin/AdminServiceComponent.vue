<template>
  <AdminNavComponent></AdminNavComponent>

  <div class="container">
    <div class="mt-3">
      <button @click="openCreateModal()" class="btn btn-primary mx-2">
        Create new
      </button>
    </div>
    <div class="mt-3">
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Salon_id</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="service in services" :key="service.id">
            <td>{{ service.id }}</td>
            <td>{{ service.name }}</td>
            <td>{{ service.salon_id }}</td>
            <td>
              <button
                @click="openUpdateModal(service)"
                class="btn btn-sm btn-primary mx-2"
              >
                Edit
              </button>
              <button
                @click="deleteService(service.id)"
                class="btn btn-sm btn-danger"
              >
                Delete
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <div class="modal" id="modalCreate">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Create new service</h5>
          <button
            type="button"
            class="btn btn-danger"
            @click="closeCreateModal()"
          >
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label>Name:</label>
              <input
                v-model="newService.name"
                type="text"
                class="form-control"
              />
              <div v-if="errorsCreate && errorsCreate.name" class="text-danger">
                {{ errorsCreate.name[0] }}
              </div>
            </div>

            <div class="form-group">
              <label>Salon ID:</label>
              <select
                v-model="newService.salon_id"
                class="form-control"
                :disabled="salons.length === 0"
              >
                <option :value="null" disabled v-if="salons.length === 0">
                  No salons
                </option>
                <option
                  v-for="salon in salons"
                  :key="salon.id"
                  :value="salon.id"
                >
                  {{ salon.id }}
                </option>
              </select>
              <div
                v-if="errorsCreate && errorsCreate.salon_id"
                class="text-danger"
              >
                {{ errorsCreate.salon_id[0] }}
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button
            :disabled="!newService.salon_id"
            @click="createService()"
            class="btn btn-primary"
          >
            Create
          </button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal" id="modalUpdate">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Update service</h5>
          <button
            type="button"
            class="btn btn-danger"
            @click="closeUpdateModal()"
          >
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form>
            <div class="form-group">
              <label>Name:</label>
              <input
                v-model="selectedService.name"
                type="text"
                class="form-control"
              />
              <div v-if="errorsUpdate && errorsUpdate.name" class="text-danger">
                {{ errorsUpdate.name[0] }}
              </div>
            </div>

            <div class="form-group">
              <label>Salon ID:</label>
              <select v-model="selectedService.salon_id" class="form-control">
                <option
                  v-for="salon in salons"
                  :key="salon.id"
                  :value="salon.id"
                >
                  {{ salon.id }}
                </option>
              </select>
              <div
                v-if="errorsUpdate && errorsUpdate.salon_id"
                class="text-danger"
              >
                {{ errorsUpdate.salon_id[0] }}
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button
            :disabled="!selectedService.salon_id"
            @click="updateService(selectedService.id)"
            class="btn btn-primary"
          >
            Update
          </button>
        </div>
      </div>
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
      services: [],
      salons: [],
      errorsCreate: null,
      errorsUpdate: null,
      newService: {
        name: null,
        salon_id: null,
      },
      selectedService: {
        id: null,
        name: null,
        salon_id: null,
      },
    };
  },
  methods: {
    loadServices() {
      axios
        .get("/api/v1/services")
        .then((response) => {
          this.services = response.data.data;
        })
        .catch((error) => {
          console.error("Ошибка при получении данных:", error);
        });
    },
    loadSalons() {
      axios
        .get("/api/v1/salons")
        .then((response) => {
          this.salons = response.data.data;
        })
        .catch((error) => {
          console.error("Ошибка при получении данных о салонах:", error);
        });
    },

    openCreateModal() {
      this.loadSalons();
      $("#modalCreate").modal("show");
    },
    closeCreateModal() {
      $("#modalCreate").modal("hide");
      this.errorsCreate = null;
    },

    createService() {
      axios
        .post("/api/v1/services/", this.newService)
        .then((response) => {
          this.closeCreateModal();
          this.loadServices();
          this.newService = {
            name: null,
            salon_id: null,
          };
          this.errorsCreate = null;
        })
        .catch((error) => {
          this.errorsCreate = error.response.data.errors;
          console.error("Ошибка при получении данных:", error);
        });
    },

    openUpdateModal(selectedService) {
      this.loadSalons();
      this.selectedService.id = selectedService.id;
      this.selectedService.name = selectedService.name;
      this.selectedService.salon_id = selectedService.salon_id;
      $("#modalUpdate").modal("show");
    },
    closeUpdateModal() {
      this.selectedService = {};
      this.errorsUpdate = null;
      $("#modalUpdate").modal("hide");
    },

    updateService(id) {
      axios
        .put("/api/v1/services/" + id, this.selectedService)
        .then((response) => {
          this.closeUpdateModal();
          this.loadServices();
          this.selectedService = {};
          this.errorsUpdate = null;
        })
        .catch((error) => {
          this.errorsUpdate = error.response.data.errors;
          console.error("Ошибка при получении данных:", error);
        });
    },

    deleteService(id) {
      axios
        .delete("/api/v1/services/" + id)
        .then((response) => {})
        .catch((error) => {
          console.error("Ошибка при получении данных:", error);
        });
      this.loadServices();
    },
  },
  mounted() {
    axios
      .get("/api/v1/services")
      .then((response) => {
        this.services = response.data.data;
      })
      .catch((error) => {
        console.error("Ошибка при получении данных:", error);
      });
  },
};
</script>