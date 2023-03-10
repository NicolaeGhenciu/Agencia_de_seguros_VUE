<template>
  <div id="app">
    <!-- v-if="$route.meta.requiresAuth" -->

    <nav
      v-if="$route.meta.requiresAuth"
      class="navbar navbar-expand-lg navbar-light bg-primary"
    >
      <div class="container-fluid">
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto">
            <li class="nav-item dropdown">
              &nbsp;&nbsp;&nbsp;&nbsp;<img
                src="img/logo.png"
                height="40px"
                width="40px"
              />
            </li>
            <li class="nav-item dropdown">&nbsp;&nbsp;</li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdown"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                style="color: black"
              >
                <b><i class="bi bi-card-checklist"></i> Listar</b>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li>
                  <router-link class="dropdown-item" to="/listarcliente"
                    ><i class="bi bi-people-fill"></i> Listar
                    Cliente</router-link
                  >
                </li>
                <li>
                  <router-link class="dropdown-item" to="/listarpoliza"
                    ><i class="bi bi-folder-fill"></i> Listar
                    Polizas</router-link
                  >
                </li>
                <li>
                  <router-link class="dropdown-item" to="/listarfiltrado"
                    ><i class="bi bi-search"></i> Listar Clientes/Polizas
                    filtrando</router-link
                  >
                </li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                id="navbarDropdown2"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                style="color: black"
              >
                <b><i class="bi bi-file-plus"></i> Insertar</b>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown2">
                <li>
                  <router-link class="dropdown-item" to="/altacliente"
                    ><i class="bi bi-person-fill-add"></i> Alta
                    Cliente</router-link
                  >
                </li>
                <li>
                  <router-link class="dropdown-item" to="/altapoliza"
                    ><i class="bi bi-journal-plus"></i> Alta Poliza</router-link
                  >
                </li>
              </ul>
            </li>
          </ul>
        </div>
        &nbsp;
        <button class="btn btn-danger" @click="logout">
          <i class="bi bi-door-open-fill"></i> Cerrar sesión
        </button>
      </div>
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
        <li class="ms-3">
          <a class="text-muted" href="#"></a>
        </li>
        <li class="ms-3"><a class="text-muted" href="#"></a></li>
      </ul>
    </footer>
  </div>
</template>

<script>
export default {
  data() {
    return {
      emailUsuario: localStorage.getItem("emailUsuario"),
    };
  },
  methods: {
    logout() {
      localStorage.removeItem("estoyLogueado");
      localStorage.removeItem("emailUsuario");
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
