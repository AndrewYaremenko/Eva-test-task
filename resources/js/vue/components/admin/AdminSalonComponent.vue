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
            <th>Address</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="salon in salons" :key="salon.id">
            <td>{{ salon.id }}</td>
            <td>{{ salon.name }}</td>
            <td>{{ salon.address }}</td>
            <td>
              <button
                @click="openUpdateModal(salon)"
                class="btn btn-sm btn-primary mx-2"
              >
                Edit
              </button>
              <button
                @click="deleteSalon(salon.id)"
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
          <h5 class="modal-title">Create new salon</h5>
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
              <input v-model="newSalon.name" type="text" class="form-control" />
              <div v-if="errorsCreate && errorsCreate.name" class="text-danger">
                {{ errorsCreate.name[0] }}
              </div>
            </div>

            <div class="form-group">
              <label>Address:</label>
              <input
                v-model="newSalon.address"
                type="text"
                class="form-control"
              />
              <div
                v-if="errorsCreate && errorsCreate.address"
                class="text-danger"
              >
                {{ errorsCreate.address[0] }}
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button
            :disabled="!newSalon.name || !newSalon.address"
            @click="createSalon()"
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
          <h5 class="modal-title">Update salon</h5>
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
                v-model="selectedSalon.name"
                type="text"
                class="form-control"
              />
              <div v-if="errorsUpdate && errorsUpdate.name" class="text-danger">
                {{ errorsUpdate.name[0] }}
              </div>
            </div>

            <div class="form-group">
              <label>Address:</label>
              <input
                v-model="selectedSalon.address"
                type="text"
                class="form-control"
              />
              <div
                v-if="errorsUpdate && errorsUpdate.address"
                class="text-danger"
              >
                {{ errorsUpdate.address[0] }}
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button
            :disabled="!selectedSalon.name || !selectedSalon.address"
            @click="updateSalon(selectedSalon.id)"
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
      salons: [],
      errorsCreate: null,
      errorsUpdate: null,
      newSalon: {
        name: null,
        address: null,
      },
      selectedSalon: {
        id: null,
        name: null,
        address: null,
      },
    };
  },
  methods: {
    loadSalons() {
      axios
        .get("/api/v1/salons")
        .then((response) => {
          this.salons = response.data.data;
        })
        .catch((error) => {
          console.error("Ошибка при получении данных:", error);
        });
    },

    openCreateModal() {
      $("#modalCreate").modal("show");
    },
    closeCreateModal() {
      $("#modalCreate").modal("hide");
      this.errorsCreate = null;
    },

    createSalon() {
      axios
        .post("/api/v1/salons/", this.newSalon)
        .then((response) => {
          this.closeCreateModal();
          this.loadSalons();
          this.newSalon = {
            name: null,
            address: null,
          };
          this.errorsCreate = null;
        })
        .catch((error) => {
          this.errorsCreate = error.response.data.errors;
          console.error("Ошибка при получении данных:", error);
        });
    },

    openUpdateModal(selectedSalon) {
      this.selectedSalon.id = selectedSalon.id;
      this.selectedSalon.name = selectedSalon.name;
      this.selectedSalon.address = selectedSalon.address;
      $("#modalUpdate").modal("show");
    },
    closeUpdateModal() {
      this.selectedSalon = {};
      this.errorsUpdate = null;
      $("#modalUpdate").modal("hide");
    },

    updateSalon(id) {
      axios
        .put("/api/v1/salons/" + id, this.selectedSalon)
        .then((response) => {
          this.closeUpdateModal();
          this.loadSalons();
          this.selectedSalon = {};
          this.errorsUpdate = null;
        })
        .catch((error) => {
          this.errorsUpdate = error.response.data.errors;
          console.error("Ошибка при получении данных:", error);
        });
    },

    deleteSalon(id) {
      axios
        .delete("/api/v1/salons/" + id)
        .then((response) => {})
        .catch((error) => {
          console.error("Ошибка при получении данных:", error);
        });
      this.loadSalons();
    },
  },
  mounted() {
    this.loadSalons();
  },
};
</script>