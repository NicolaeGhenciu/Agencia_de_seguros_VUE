<template>
  <div id="contenido">
    <h3>Lista de polizas</h3>
    <div class="container col-md-2">
      <select v-model="estadoSeleccionado" class="form-select">
        <option value="">Todo</option>
        <option value="liquidada">Liquidada</option>
        <option value="anulada">Anulada</option>
        <option value="a_cuenta">A cuenta</option>
        <option value="cobrada">Cobrada</option>
        <option value="pre-anulada">Pre-anulada</option>
      </select>
    </div>
    <br />
    <table id="tabla-polizas" class="table table-striped table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Cliente ID</th>
          <th>Numero Poliza</th>
          <th>Importe de recibo</th>
          <th>Fecha</th>
          <th>Estado</th>
          <th>Observaciones</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="poliza in polizas.filter(polizaEstadoSeleccionado)"
          :key="poliza.id"
          :class="{
            'bg-warning': poliza.estado === 'liquidada',
            'bg-danger': poliza.estado === 'anulada',
            'bg-info': poliza.estado === 'a_cuenta',
            'bg-success': poliza.estado === 'cobrada',
            'bg-primary': poliza.estado === 'pre-anulada',
          }"
        >
          <td>{{ poliza.id }}</td>
          <td>
            <button
              class="btn btn-light"
              @click="verDetalles(poliza.id_cliente)"
            >
              {{ poliza.id_cliente }}
            </button>
          </td>
          <td>{{ poliza.numero_poliza }}</td>
          <td>{{ poliza.importe_recibo }} €</td>
          <td>{{ poliza.fecha | date("DD-MM-YYYY") }}</td>
          <td>
            <span v-if="poliza.estado === 'liquidada'">Liquidada</span>
            <span v-if="poliza.estado === 'anulada'">Anulada</span>
            <span v-if="poliza.estado === 'a_cuenta'">A cuenta</span>
            <span v-if="poliza.estado === 'cobrada'">Cobrada</span>
            <span v-if="poliza.estado === 'pre-anulada'">Pre-anulada</span>
          </td>
          <td>{{ poliza.observaciones }}</td>
          <td>
            <button
              class="btn btn-warning border border-dark"
              @click="editarPoliza(poliza.id)"
            >
              <i class="bi bi-pencil-square"></i></button
            >&nbsp;
            <button
              type="button"
              class="btn btn-danger border border-dark"
              data-bs-toggle="modal"
              data-bs-target="#staticBackdrop"
              @click="almacenarPoliza(poliza)"
            >
              <i class="bi bi-trash-fill"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <!-- Modal -->
    <div
      class="modal fade"
      id="staticBackdrop"
      data-bs-backdrop="static"
      data-bs-keyboard="false"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">
              <i class="bi bi-trash-fill"></i> Confirmación de anulacion de
              poliza
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            ¿Esta seguro de querer anular la poliza
            <b>{{ this.poliza_Almacenado.id }}</b> ?
            <p></p>
            <p><b>Cliente ID:</b> {{ this.poliza_Almacenado.id_cliente }}</p>
            <p>
              <b>Numero poliza:</b> {{ this.poliza_Almacenado.numero_poliza }}
            </p>
            <p>
              <b>Importe de recibo:</b>
              {{ this.poliza_Almacenado.importe_recibo }} €
            </p>
            <p>
              <b>Fecha:</b>
              {{ this.poliza_Almacenado.fecha | date("DD-MM-YYYY") }}
            </p>
            <p>
              <b>Estado: </b>
              <span v-if="this.poliza_Almacenado.estado === 'liquidada'"
                >Liquidada</span
              >
              <span v-if="this.poliza_Almacenado.estado === 'anulada'"
                >Anulada</span
              >
              <span v-if="this.poliza_Almacenado.estado === 'a_cuenta'"
                >A cuenta</span
              >
              <span v-if="this.poliza_Almacenado.estado === 'cobrada'"
                >Cobrada</span
              >
              <span v-if="this.poliza_Almacenado.estado === 'pre-anulada'"
                >Pre-anulada</span
              >
            </p>
            <p>
              <b>Observaciones:</b> {{ this.poliza_Almacenado.observaciones }}
            </p>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              <i class="bi bi-arrow-left"></i> Cerrar
            </button>
            <button
              class="btn btn-danger"
              data-bs-dismiss="modal"
              v-on:click="borrarPoliza(poliza_Almacenado.id)"
            >
              <i class="bi bi-trash-fill"></i> Anular
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
    
    <script>
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";

export default {
  data() {
    return {
      polizas: [],
      poliza_Almacenado: [],
      estadoSeleccionado: "",
    };
  },
  filters: {
    date: function (value) {
      if (!value) return "";
      return new Date(value).toLocaleDateString("es-ES");
    },
  },
  created: function () {
    this.consultarPolizas();
  },
  methods: {
    polizaEstadoSeleccionado(poliza) {
      if (this.estadoSeleccionado == "") {
        return poliza.estado;
      }
      return poliza.estado === this.estadoSeleccionado;
    },
    verDetalles(id) {
      this.$router.push({ name: "DetallesCliente", query: { id: id } });
    },
    editarPoliza(id) {
      this.$router.push({ name: "EditarPoliza", query: { id: id } });
    },
    consultarPolizas() {
      fetch("PHP/agencia.php/?consultar_polizas")
        .then((respuesta) => respuesta.json())
        .then((datosRespuesta) => {
          console.log(datosRespuesta);
          this.polizas = [];
          if (typeof datosRespuesta[0].success === "undefined") {
            this.polizas = datosRespuesta;
          }
        });
    },
    borrarPoliza(id) {
      console.log(id);
      fetch("PHP/agencia.php/?borrar_poliza=" + id)
        .then((resp) => resp.json())
        .then((datosResp) => {
          console.log(datosResp);
          this.consultarPolizas();
        })
        .catch(console.log);
    },
    almacenarPoliza(poliza) {
      console.log(poliza);
      this.poliza_Almacenado = poliza;
    },
  },
};
</script>
    
    <style>
#contenido {
  margin: 2em;
}
</style>
    