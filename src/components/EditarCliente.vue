<template>
  <div class="card m-5">
    <div class="card-header"><b>Editar cliente</b></div>
    <form class="row g-3 m-4">
      <div class="col-md-3">
        <label for="nombre"><b>Nombre:</b></label>
        <input
          class="form-control"
          type="text"
          id="nombre"
          v-model="cliente.nombre"
          placeholder="Ingrese el nombre del cliente"
        />
        <div class="col-md-12">
          <div
            class="alert alert-danger"
            role="alert"
            v-if="errores_de_validacion['validacion_nombre'] != ''"
          >
            <span>{{ errores_de_validacion["validacion_nombre"] }}</span>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <label for="apellidos"><b>Apellidos:</b></label>
        <input
          class="form-control"
          type="text"
          id="apellidos"
          v-model="cliente.apellidos"
          placeholder="Ingrese los apellidos del cliente"
        />
        <div class="col-md-12">
          <div
            class="alert alert-danger"
            role="alert"
            v-if="errores_de_validacion['validacion_apellidos'] != ''"
          >
            <span>{{ errores_de_validacion["validacion_apellidos"] }}</span>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <label for="telefono"><b>Teléfono:</b></label>
        <input
          class="form-control"
          type="number"
          id="telefono"
          v-model="cliente.telefono"
          placeholder="Ingrese el teléfono del cliente"
        />
        <div class="col-md-12">
          <div
            class="alert alert-danger"
            role="alert"
            v-if="errores_de_validacion['validacion_telefono'] != ''"
          >
            <span>{{ errores_de_validacion["validacion_telefono"] }}</span>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <label for="cp"><b>Código Postal:</b></label>
        <input
          class="form-control"
          type="number"
          id="cp"
          v-model="cliente.cp"
          placeholder="Ingrese el código postal del cliente"
        />
        <div class="col-md-12">
          <div
            class="alert alert-danger"
            role="alert"
            v-if="errores_de_validacion['validacion_cp'] != ''"
          >
            <span>{{ errores_de_validacion["validacion_cp"] }}</span>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <label for="provincia"><b>Provincia:</b></label>
        <select class="form-select" id="provincia" v-model="cliente.provincia">
          <option
            v-for="provincia in provincias"
            :value="provincia.id"
            :key="provincia.provincia"
          >
            {{ provincia.provincia }}
          </option>
        </select>
        <div class="col-md-12">
          <div
            class="alert alert-danger"
            role="alert"
            v-if="errores_de_validacion['validacion_provincia'] != ''"
          >
            <span>{{ errores_de_validacion["validacion_provincia"] }}</span>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <label for="localidad"><b>Localidad:</b></label>
        <select v-model="cliente.localidad" class="form-select" id="localidad">
          <option
            v-for="municipio in municipios"
            :value="municipio.municipio"
            :key="municipio.municipio"
          >
            {{ municipio.municipio }}
          </option>
        </select>
        <div class="col-md-12">
          <div
            class="alert alert-danger"
            role="alert"
            v-if="errores_de_validacion['validacion_localidad'] != ''"
          >
            <span>{{ errores_de_validacion["validacion_localidad"] }}</span>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <label for="entidad"><b>Entidad:</b></label>
        <div class="form-check">
          <input
            class="form-check-input"
            type="radio"
            id="entidad"
            value="empresa"
            v-model="cliente.entidad"
          />
          Empresa
        </div>
        <div class="form-check">
          <input
            class="form-check-input"
            type="radio"
            id="entidad"
            value="particular"
            v-model="cliente.entidad"
          />
          Particular
        </div>
        <div class="col-md-12">
          <div
            class="alert alert-danger"
            role="alert"
            v-if="errores_de_validacion['validacion_entidad'] != ''"
          >
            <span>{{ errores_de_validacion["validacion_entidad"] }}</span>
          </div>
        </div>
      </div>

      <button class="btn btn-primary" @click.prevent="actualizarCliente">
        Enviar
      </button>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      cliente: {
        nombre: "",
        apellidos: "",
        telefono: "",
        localidad: "",
        cp: "",
        provincia: "",
        provincia_nombre: "",
        entidad: "",
        estado: "",
      },
      provincias: [],
      municipios: [],
      hay_error: false,
      errores_de_validacion: {
        validacion_nombre: "",
        validacion_apellidos: "",
        validacion_telefono: "",
        validacion_localidad: "",
        validacion_cp: "",
        validacion_provincia: "",
        validacion_entidad: "",
        validacion_estado: "",
      },
    };
  },
  created() {
    this.fetchClienteDetails();
  },
  methods: {
    fetchClienteDetails() {
      let clienteId = this.$route.query.id;
      fetch("PHP/agencia.php/?consultar_cliente=" + clienteId)
        .then((response) => response.json())
        .then((data) => {
          console.log(data[0]);
          this.cliente = data[0];
        })
        .catch((error) => {
          console.error(error);
        });
    },
    async actualizarCliente() {

      const provincia = this.provincias.find(
        (p) => p.id === this.cliente.provincia
      );

      // Cambiamos el valor de cliente.provincia de id a nombre
      this.cliente.provincia_nombre = provincia.provincia;
      
      this.validacion();
      if (this.hay_error == false) {
        const clienteActualizado = {
          id: this.cliente.id,
          nombre: this.cliente.nombre,
          apellidos: this.cliente.apellidos,
          telefono: this.cliente.telefono,
          localidad: this.cliente.localidad,
          cp: this.cliente.cp,
          provincia: this.cliente.provincia,
          provincia_nombre: this.cliente.provincia_nombre,
          entidad: this.cliente.entidad,
        };
        console.log(clienteActualizado);
        await fetch(
          "PHP/agencia.php/?actualizar_cliente=" + this.$route.params.id,
          {
            method: "POST",
            body: JSON.stringify(clienteActualizado),
          }
        )
          .then((respuesta) => respuesta.json())
          .then((datosRespuesta) => {
            console.log(datosRespuesta);
            this.$router.push({ name: "ListarCliente" });
          });
      }
    },
    async consultar_provincia() {
      const respuesta = await fetch("PHP/agencia.php/?consultar_provincias");
      const datosRespuesta = await respuesta.json();
      this.provincias = datosRespuesta;
    },
    async consultar_municipios() {
      console.log(this.cliente.provincia);
      const respuesta = await fetch(
        `PHP/agencia.php/?consultar_municipios=${this.cliente.provincia}`
      );
      const datosRespuesta = await respuesta.json();
      this.municipios = datosRespuesta;
      console.log(this.municipios);
    },
    validacion() {
      if (
        this.cliente.nombre == "" ||
        this.cliente.apellidos == "" ||
        this.cliente.telefono == "" ||
        this.cliente.cp == "" ||
        this.cliente.provincia == "" ||
        this.cliente.localidad == "" ||
        this.cliente.entidad == ""
      ) {
        if (this.cliente.nombre == "") {
          this.hay_error = true;
          this.errores_de_validacion["validacion_nombre"] =
            "Nombre no puede estar vacio";
        } else {
          this.errores_de_validacion["validacion_nombre"] = "";
        }
        if (this.cliente.apellidos == "") {
          this.hay_error = true;
          this.errores_de_validacion["validacion_apellidos"] =
            "Apellidos no puede estar vacio";
        } else {
          this.errores_de_validacion["validacion_apellidos"] = "";
        }
        if (this.cliente.telefono == "") {
          this.hay_error = true;
          this.errores_de_validacion["validacion_telefono"] =
            "Telefono no puede estar vacio";
        } else {
          this.errores_de_validacion["validacion_telefono"] = "";
        }
        if (this.cliente.cp == "") {
          this.hay_error = true;
          this.errores_de_validacion["validacion_cp"] =
            "Código postal no puede estar vacio";
        } else {
          this.errores_de_validacion["validacion_cp"] = "";
        }
        if (this.cliente.provincia == "") {
          this.hay_error = true;
          this.errores_de_validacion["validacion_provincia"] =
            "Provincia no puede estar vacio";
        } else {
          this.errores_de_validacion["validacion_provincia"] = "";
        }
        if (this.cliente.localidad == "") {
          this.hay_error = true;
          this.errores_de_validacion["validacion_localidad"] =
            "Localidad no puede estar vacio";
        } else {
          this.errores_de_validacion["validacion_localidad"] = "";
        }
        if (this.cliente.entidad == "") {
          this.hay_error = true;
          this.errores_de_validacion["validacion_entidad"] =
            "Entidad no puede estar sin seleccionar";
        } else {
          this.errores_de_validacion["validacion_entidad"] = "";
        }
      } else {
        this.hay_error = false;
      }
    },
  },
  watch: {
    "cliente.provincia": function () {
      this.consultar_municipios();
    },
  },
  mounted() {
    this.consultar_provincia();
  },
};
</script>