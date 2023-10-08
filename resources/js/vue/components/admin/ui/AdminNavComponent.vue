<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <router-link class="navbar-brand" to="/admin">Dashboard</router-link>

      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
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
    </div>
  </nav>
</template>