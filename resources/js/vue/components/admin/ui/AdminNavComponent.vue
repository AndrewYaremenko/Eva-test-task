<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <router-link class="navbar-brand" to="/admin">Dashboard</router-link>

      <div class="navbar-nav">
        <router-link class="nav-link" to="/admin/salons">Salons</router-link>
        <router-link class="nav-link" to="/admin/services"
          >Services</router-link
        >
        <router-link class="nav-link" to="/admin/appointments"
          >Appointments</router-link
        >
      </div>
      
    </div>
  </nav>
</template>