<template>
  <div class="card m-5">
    <div class="card-header"><b>Formulario alta de cliente</b></div>
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
          <option disabled selected value="">Seleccione una provincia</option>
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
          <option disabled selected value="">Seleccione una localidad</option>
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

      <button class="btn btn-primary" @click.prevent="agregarRegistro">
        Enviar
      </button>
    </form>
  </div>
</template>

<script>
//Intento de implementar select2 en el proyecto
// import $ from "jquery";
// import "select2";
// import "select2/dist/css/select2.css";
// import "select2/dist/js/select2.js";

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
        estado: "alta",
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
  methods: {
    //insertamos el cliente
    async agregarRegistro() {
      const provincia = this.provincias.find(
        (p) => p.id === this.cliente.provincia
      );

      // Cambiamos el valor de cliente.provincia de id a nombre
      this.cliente.provincia_nombre = provincia.provincia;

      console.log(this.cliente);
      this.validacion();
      if (this.hay_error == false) {
        const respuesta = await fetch("PHP/agencia.php/?insertar=1", {
          method: "POST",
          body: JSON.stringify(this.cliente),
          headers: {
            "Content-Type": "application/json",
          },
        });

        const datosRespuesta = await respuesta.json();
        console.log(datosRespuesta);
        this.$router.push({ name: "ListarCliente" });
      }
    },
    // consultamos los datos de todas las provincias
    async consultar_provincia() {
      const respuesta = await fetch("PHP/agencia.php/?consultar_provincias");
      const datosRespuesta = await respuesta.json();
      this.provincias = datosRespuesta;
    },
    //consultamos los datos de todos los municipios
    async consultar_municipios() {
      console.log(this.cliente.provincia);
      const respuesta = await fetch(
        `PHP/agencia.php/?consultar_municipios=${this.cliente.provincia}`
      );
      const datosRespuesta = await respuesta.json();
      this.municipios = datosRespuesta;
      console.log(this.municipios);

      // Actualizar el valor de cliente.provincia cuando se seleccione una nueva opción, esto es para el select2
      // $("#provincia").on("change", (e) => {
      //   this.cliente.provincia = e.target.value;
      // });
    },
    //aqui hacemos las validaciones pertinentes
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
    // $("#provincia").select2();
  },
};
</script>