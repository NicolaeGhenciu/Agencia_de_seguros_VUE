<template>
  <div class="card m-5">
    <div class="card-header">
      <b
        ><i class="bi bi-journal-plus"></i> Nueva poliza para
        {{ this.nombreCliente }}</b
      >
    </div>
    <form class="row g-3 m-4">
      <div class="col-md-3">
        <label for="numero_poliza"><b>Numero poliza:</b></label>
        <input
          class="form-control"
          type="text"
          placeholder="Ingresa el número de la póliza"
          id="numero_poliza"
          v-model="poliza.numero_poliza"
        />
        <div class="col-md-12">
          <div
            class="alert alert-danger"
            role="alert"
            v-if="errores_de_validacion['validacion_numero_poliza'] != ''"
          >
            <span>{{ errores_de_validacion["validacion_numero_poliza"] }}</span>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <input-group>
          <label for="importe_recibo"><b>Importe recibo:</b></label>
          <div class="input-group">
            <input
              class="form-control"
              type="number"
              placeholder="0"
              id="importe_recibo"
              v-model="poliza.importe_recibo"
            />
            <span class="input-group-text">€</span>
          </div>
          <div class="col-md-12">
            <div
              class="alert alert-danger"
              role="alert"
              v-if="errores_de_validacion['validacion_importe_recibo'] != ''"
            >
              <span>{{
                errores_de_validacion["validacion_importe_recibo"]
              }}</span>
            </div>
          </div>
        </input-group>
      </div>

      <div class="col-md-3">
        <label for="fecha"><b>Fecha alta:</b></label>
        <input
          class="form-control"
          type="date"
          id="fecha"
          v-model="poliza.fecha"
        />
        <div class="col-md-12">
          <div
            class="alert alert-danger"
            role="alert"
            v-if="errores_de_validacion['validacion_fecha']"
          >
            <span>{{ errores_de_validacion["validacion_fecha"] }}</span>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <label for="estado"><b>Estado</b></label>
        <select class="form-select" id="estado" v-model="poliza.estado">
          <option disabled selected value="">Seleccione un estado</option>
          <option value="cobrada">Cobrada</option>
          <option value="a_cuenta">A cuenta</option>
          <option value="liquidada">Liquidada</option>
          <option value="anulada">Anulada</option>
          <option value="pre-anulada">Pre-anulada</option>
        </select>
        <div class="col-md-12">
          <div
            class="alert alert-danger"
            role="alert"
            v-if="errores_de_validacion['validacion_estado'] != ''"
          >
            <span>{{ errores_de_validacion["validacion_estado"] }}</span>
          </div>
        </div>
      </div>

      <div class="col-md-12">
        <label for="observaciones"><b>Observaciones:</b></label>
        <textarea
          class="form-control"
          placeholder="Escriba aquí cualquier observación adicional"
          id="observaciones"
          v-model="poliza.observaciones"
        ></textarea>
        <div class="col-md-12">
          <div
            class="alert alert-danger"
            role="alert"
            v-if="errores_de_validacion['validacion_observaciones'] != ''"
          >
            <span>{{ errores_de_validacion["validacion_observaciones"] }}</span>
          </div>
        </div>
      </div>

      <div class="btn-group">
        <button class="btn btn-warning" @click="$router.go(-1)">
          <i class="bi bi-x-circle"></i> Cancelar
        </button>
        <!-- <router-link to="/listarcliente" class="btn btn-warning">
          <i class="bi bi-x-circle"></i> Cancelar
        </router-link> -->
        <button class="btn btn-primary" @click.prevent="agregarRegistro">
          <i class="bi bi-sd-card"></i> Guardar
        </button>
      </div>
    </form>
  </div>
</template>
    
    <script>
export default {
  data() {
    return {
      poliza: {
        id_cliente: this.$route.query.id,
        numero_poliza: "",
        importe_recibo: "",
        fecha: "",
        estado: "",
        observaciones: "",
      },
      clientes: [],
      nombreCliente: "",
      hay_error: false,
      errores_de_validacion: {
        validacion_id_cliente: "",
        validacion_numero_poliza: "",
        validacion_importe_recibo: "",
        validacion_fecha: "",
        validacion_estado: "",
        validacion_observaciones: "",
      },
    };
  },
  methods: {
    //consultamos los datos para cargar los datos en la variable clientes[]
    async consultar_clientes() {
      const respuesta = await fetch("PHP/agencia.php/?consultar_clientes");
      const datosRespuesta = await respuesta.json();
      this.clientes = datosRespuesta;
      for (let i = 0; i < this.clientes.length; i++) {
        if (this.clientes[i].id == this.$route.query.id) {
          this.nombreCliente =
            this.clientes[i].nombre + " " + this.clientes[i].apellidos;
        }
      }
    },
    //aqui hacemos las validaciones pertinentes
    validacion() {
      if (
        this.poliza.id_cliente == "" ||
        this.poliza.numero_poliza == "" ||
        this.poliza.importe_recibo == "" ||
        this.poliza.fecha == "" ||
        this.poliza.estado == "" ||
        this.poliza.observaciones == ""
      ) {
        if (this.poliza.id_cliente == "") {
          this.hay_error = true;
          this.errores_de_validacion["validacion_id_cliente"] =
            "ID cliente no puede estar vacio";
        } else {
          this.errores_de_validacion["validacion_id_cliente"] = "";
        }
        if (this.poliza.numero_poliza == "") {
          this.hay_error = true;
          this.errores_de_validacion["validacion_numero_poliza"] =
            "Numero poliza no puede estar vacio";
          console.log("hola");
        } else {
          this.errores_de_validacion["validacion_numero_poliza"] = "";
        }
        if (this.poliza.importe_recibo == "") {
          this.hay_error = true;
          this.errores_de_validacion["validacion_importe_recibo"] =
            "Importe recibo no puede estar vacio";
        } else {
          this.errores_de_validacion["validacion_importe_recibo"] = "";
        }
        let today = new Date();
        let fechaPoliza = new Date(this.poliza.fecha);
        if (fechaPoliza < today || this.poliza.fecha == "") {
          this.hay_error = true;
          this.errores_de_validacion["validacion_fecha"] =
            "La fecha no puede ser anterior ni igual a la de hoy";
        } else {
          this.errores_de_validacion["validacion_fecha"] = "";
        }
        if (this.poliza.estado == "") {
          this.hay_error = true;
          this.errores_de_validacion["validacion_estado"] =
            "Estado no puede estar vacio";
        } else {
          this.errores_de_validacion["validacion_estado"] = "";
        }
        if (this.poliza.observaciones == "") {
          this.hay_error = true;
          this.errores_de_validacion["validacion_observaciones"] =
            "Observaciones no puede estar vacio";
        } else {
          this.errores_de_validacion["validacion_observaciones"] = "";
        }
      } else {
        this.hay_error = false;
      }
    },
    //aqui hacemos el insert
    async agregarRegistro() {
      this.validacion();
      if (this.hay_error == false) {
        console.log(this.poliza);
        const respuesta = await fetch("PHP/agencia.php/?insertar_poliza=1", {
          method: "POST",
          body: JSON.stringify(this.poliza),
          headers: {
            "Content-Type": "application/json",
          },
        });
        const datosRespuesta = await respuesta.json();
        console.log(datosRespuesta);
        this.$router.go(-1);
      }
    },
  },
  mounted() {
    this.consultar_clientes();
  },
};
</script>