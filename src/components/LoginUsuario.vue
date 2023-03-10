<template>
  <div class="d-flex align-items-center h-100 mt-5">
    <div class="card mx-auto" style="width: 25rem">
      <div class="card-body bg-info">
        <form @submit.prevent="login">
          <h3>Login AXA Seguros</h3>
          <div class="text-center">
            <img src="img/logo.png" height="100px" width="100px" />
          </div>
          <div class="form-group mt-3 mb-4">
            <input
              type="email"
              class="form-control form-input"
              v-model="email"
              placeholder="Email"
              required
            />
            <div v-if="errorEmail" class="alert alert-danger mt-2">
              Email incorrecto
            </div>
          </div>
          <div class="form-group mt-4 mb-4">
            <input
              type="password"
              class="form-control form-input"
              v-model="password"
              placeholder="Contraseña"
              required
            />
            <div v-if="errorPassword" class="alert alert-danger mt-2">
              Contraseña incorrecta
            </div>
          </div>
          <button type="submit" class="btn btn-primary mt-3">Login</button>
        </form>
        <hr />
        <p>Credenciales:</p>
        <p>Email: <b>docarmo@gmail.com</b></p>
        <p>Contraseña: <b>docarmo</b></p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      password: "",
      errorEmail: false,
      errorPassword: false,
    };
  },
  methods: {
    async login() {
      this.errorEmail = false;
      this.errorPassword = false;
      const response = await fetch("PHP/agencia.php/?login=" + this.email);
      const usuarios = await response.json();
      if (usuarios.length > 0 && usuarios[0].pass === this.password) {
        localStorage.setItem("estoyLogueado", true);
        localStorage.setItem("emailUsuario", this.email);
        this.$router.push({ name: "ListarCliente" });
      } else {
        this.errorEmail = true;
        this.errorPassword = true;
        localStorage.removeItem("estoyLogueado");
      }
    },
  },
};
</script>