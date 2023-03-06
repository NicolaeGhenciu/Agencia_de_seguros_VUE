<template>
  <div id="app">
    <!-- v-if="$route.meta.requiresAuth" -->
    <nav v-if="$route.meta.requiresAuth">
      <router-link to="/altacliente"
        ><i class="bi bi-person-fill-add"></i> Alta Cliente</router-link
      >
      |
      <router-link to="/altapoliza"
        ><i class="bi bi-journal-plus"></i> Alta Poliza</router-link
      >
      |
      <router-link to="/listarcliente"
        ><i class="bi bi-people-fill"></i> Listar Cliente</router-link
      >
      |
      <router-link to="/listarpoliza"
        ><i class="bi bi-folder-fill"></i> Listar Polizas</router-link
      >
      |
      <router-link to="/listarpolizafiltrado"
        ><i class="bi bi-folder-fill"></i> Listar Polizas Filtrado</router-link
      >
      |
      <button class="badge bg-danger" @click="logout">
        <i class="bi bi-door-open-fill"></i> Cerrar sesión
      </button>
    </nav>
    <router-view />
    <footer
      class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top"
      v-if="$route.meta.requiresAuth"
    >
      <div class="col-md-4 d-flex align-items-center">
        <a
          href="/"
          class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1"
        >
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </a>
        <span class="mb-3 mb-md-0 text-muted"
          >© 2023 Nicolae Adrian Ghenciu</span
        >
      </div>

      <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
        <li class="ms-3">
          <a class="text-muted" href="#"><i class="bi bi-github"></i></a>
        </li>
        <li class="ms-3">
          <a class="text-muted" href="#"><i class="bi bi-facebook"></i></a>
        </li>
        <li class="ms-3">
          <a class="text-muted" href="#"><i class="bi bi-whatsapp"></i></a>
        </li>
        <li class="ms-3"><a class="text-muted" href="#"></a></li>
        <li class="ms-3"><a class="text-muted" href="#"></a></li>
      </ul>
    </footer>
  </div>
</template>

<script>
export default {
  methods: {
    logout() {
      localStorage.removeItem("estoyLogueado");
      this.$router.push("/");
    },
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
