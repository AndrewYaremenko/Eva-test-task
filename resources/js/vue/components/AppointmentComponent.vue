<template>
  <div class="container col-md-4 offset-md-4 mt-4">
    <h1 class="mb-4">Вибір салону та послуги</h1>
    <div>
      <VueDatePicker
        v-model="date"
        :min-date="new Date()"
        :disabled-week-days="[0]"
        :enable-time-picker="false"
        auto-apply
      ></VueDatePicker>
      {{ this.date }}
    </div>
  </div>
</template>

<script>
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

export default {
  components: { VueDatePicker },
  data() {
    return {
      date: null,
    };
  },
};
</script>
