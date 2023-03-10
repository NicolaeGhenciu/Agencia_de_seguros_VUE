<template>
  <div id="contenido">
    <h3>Filtrar por:</h3>

    <hr />

    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="form-group">
            <label for="provincias" class="form-label">Provincia:</label>
            <select
              id="provincias"
              class="form-select"
              v-model="provinciaSeleccionada"
            >
              <option value="">Todo</option>
              <option
                v-for="provincia in provincias"
                :value="provincia.id"
                :key="provincia.id"
              >
                {{ provincia.provincia }}
              </option>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="entidades" class="form-label">Entidad:</label>
            <select
              id="entidades"
              class="form-select"
              v-model="entidadSeleccionada"
            >
              <option value="">Todo</option>
              <option value="empresa">Empresa</option>
              <option value="particular">Particular</option>
            </select>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="fechaDesde" class="form-label">Desde:</label>
            <input
              type="date"
              id="fechaDesde"
              class="form-control"
              v-model="fechaDesde"
            />
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="fechaHasta" class="form-label">Hasta:</label>
            <input
              type="date"
              id="fechaHasta"
              class="form-control"
              v-model="fechaHasta"
            />
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group">
            <label for="estado" class="form-label">Estado:</label>
            <select
              id="estado"
              class="form-select"
              v-model="estadoSeleccionado"
            >
              <option value="">Todo</option>
              <option value="liquidada">Liquidada</option>
              <option value="anulada">Anulada</option>
              <option value="a_cuenta">A cuenta</option>
              <option value="cobrada">Cobrada</option>
              <option value="pre-anulada">Pre-anulada</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <!-- <button class="btn btn-primary my-2" @click="añadirClienteRuta()">
      <i class="bi bi-person-fill-add"></i> Nuevo Cliente
    </button> -->

    <hr />

    <h3>Lista de clientes</h3>

    <table id="tabla-clientes" class="table table-striped table-bordered">
      <thead class="thead-dark">
        <tr style="background-color: #d8f8e1">
          <th>Nombre</th>
          <th>Apellidos</th>
          <th>Teléfono</th>
          <th>Provincia</th>
          <th>Entidad</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="cliente in clientesFiltrados" :key="cliente.id">
          <td>{{ cliente.nombre }}</td>
          <td>{{ cliente.apellidos }}</td>
          <td>{{ cliente.telefono }}</td>
          <td>{{ cliente.provincia_nombre }}</td>
          <td v-if="cliente.entidad === 'empresa'">
            <i class="bi bi-building"></i> Empresa
          </td>
          <td v-else><i class="bi bi-person-fill"></i> Particular</td>
          <!-- <td>{{ cliente.entidad }}</td> -->
          <td>
            <button class="btn btn-info" @click="verDetalles(cliente.id)">
              <i class="bi bi-eye-fill"></i></button
            >&nbsp;
            <button class="btn btn-warning" @click="editarCliente(cliente.id)">
              <i class="bi bi-pencil-square"></i></button
            >&nbsp;
            <button
              class="btn btn-success"
              @click="nuevaPolizaCliente(cliente.id)"
            >
              <i class="bi bi-journal-plus"></i></button
            >&nbsp;
            <button
              type="button"
              class="btn btn-danger"
              data-bs-toggle="modal"
              data-bs-target="#staticBackdrop"
              @click="almacenarCliente(cliente)"
            >
              <i class="bi bi-trash-fill"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <hr />
    <h3>Lista de polizas</h3>

    <table id="tabla-polizas" class="table table-striped table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>Cliente</th>
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
          v-for="poliza in polizasFiltradas"
          :key="poliza.id"
          :style="{
            backgroundColor:
              poliza.estado === 'liquidada'
                ? '#77dd77'
                : poliza.estado === 'anulada'
                ? '#ff6961'
                : poliza.estado === 'a_cuenta'
                ? '#ff6961'
                : poliza.estado === 'cobrada'
                ? '#ff6961'
                : poliza.estado === 'pre-anulada'
                ? '#ff6961'
                : '',
          }"
        >
          <td>
            <button
              class="btn btn-light"
              @click="verDetalles(poliza.id_cliente)"
            >
              <i class="bi bi-person-vcard"></i> <b>{{ poliza.id_cliente }}</b>
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
              data-bs-target="#staticBackdrope"
              @click="almacenarPoliza(poliza)"
              v-if="poliza.estado && poliza.estado !== 'anulada'"
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
              <i class="bi bi-trash-fill"></i> Confirmación de baja de
              <b>{{ this.cliente_Almacenado.nombre }}</b
              >&nbsp;<b>{{ this.cliente_Almacenado.apellidos }}</b>
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            ¿Esta seguro de querer dar de baja a este cliente?
            <p></p>
            <p><b>Nombre:</b> {{ this.cliente_Almacenado.nombre }}</p>
            <p><b>Apellidos:</b> {{ this.cliente_Almacenado.apellidos }}</p>
            <p><b>Teléfono:</b> {{ this.cliente_Almacenado.telefono }}</p>
            <p><b>Localidad:</b> {{ this.cliente_Almacenado.localidad }}</p>
            <p><b>Código Postal:</b> {{ this.cliente_Almacenado.cp }}</p>
            <p>
              <b>Provincia:</b> {{ this.cliente_Almacenado.provincia_nombre }}
            </p>
            <p>
              <b>Entidad: </b>
              <span v-if="this.cliente_Almacenado.entidad === 'empresa'"
                ><i class="bi bi-building"></i> Empresa</span
              >
              <span v-else><i class="bi bi-person-fill"></i> Particular</span>
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
              v-on:click="borrarCliente(cliente_Almacenado.id)"
            >
              <i class="bi bi-trash-fill"></i> Dar de Baja
            </button>
          </div>
        </div>
      </div>
    </div>
    <div
      class="modal fade"
      id="staticBackdrope"
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
      clientes: [],
      cliente_Almacenado: [],
      provincias: [],
      polizas: [],
      poliza_Almacenado: [],
      entidadSeleccionada: "",
      provinciaSeleccionada: "",
      estadoSeleccionado: "",
      fechaDesde: null,
      fechaHasta: null,
    };
  },
  filters: {
    date: function (value) {
      if (!value) return "";
      return new Date(value).toLocaleDateString("es-ES");
    },
  },
  created: function () {
    this.consultarClientes();
    this.consultar_provincia();
    this.consultarPolizas();
  },
  computed: {
    polizasFiltradas() {
      const clientesFiltrados = this.clientes.filter((cliente) => {
        let entidadCoincide = false;
        let provinciaCoincide = false;

        if (
          !this.entidadSeleccionada ||
          cliente.entidad === this.entidadSeleccionada
        ) {
          entidadCoincide = true;
        }

        if (
          !this.provinciaSeleccionada ||
          cliente.provincia === this.provinciaSeleccionada
        ) {
          provinciaCoincide = true;
        }

        return entidadCoincide && provinciaCoincide;
      });

      // Filtrar pólizas por id_cliente de los clientes filtrados previamente y por fechaDesde y fechaHasta
      return this.polizas.filter((poliza) => {
        const fechaPoliza = new Date(poliza.fecha);
        const fechaDesde = this.fechaDesde ? new Date(this.fechaDesde) : null;
        const fechaHasta = this.fechaHasta ? new Date(this.fechaHasta) : null;

        const cumpleFechaDesde = !fechaDesde || fechaPoliza >= fechaDesde;
        const cumpleFechaHasta = !fechaHasta || fechaPoliza <= fechaHasta;

        const clienteFiltrado = clientesFiltrados.some(
          (cliente) => cliente.id === poliza.id_cliente
        );

        if (this.estadoSeleccionado) {
          return (
            clienteFiltrado &&
            cumpleFechaDesde &&
            cumpleFechaHasta &&
            poliza.estado === this.estadoSeleccionado
          );
        } else {
          return clienteFiltrado && cumpleFechaDesde && cumpleFechaHasta;
        }
      });
    },
    clientesFiltrados() {
      return this.clientes.filter((cliente) => {
        let entidadCoincide = false;
        let provinciaCoincide = false;

        console.log(this.entidadSeleccionada);
        console.log(this.provinciaSeleccionada);

        if (
          !this.entidadSeleccionada ||
          cliente.entidad === this.entidadSeleccionada
        ) {
          entidadCoincide = true;
        }

        if (
          !this.provinciaSeleccionada ||
          cliente.provincia === this.provinciaSeleccionada
        ) {
          provinciaCoincide = true;
        }

        return entidadCoincide && provinciaCoincide;
      });
    },
  },
  methods: {
    verDetalles(id) {
      this.$router.push({ name: "DetallesCliente", query: { id: id } });
    },
    editarCliente(id) {
      this.$router.push({ name: "EditarCliente", query: { id: id } });
    },
    editarPoliza(id) {
      this.$router.push({ name: "EditarPoliza", query: { id: id } });
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
    consultarClientes() {
      fetch("PHP/agencia.php/?consultar_clientes")
        .then((respuesta) => respuesta.json())
        .then((datosRespuesta) => {
          console.log(datosRespuesta);
          this.clientes = [];
          if (typeof datosRespuesta[0].success === "undefined") {
            this.clientes = datosRespuesta;
          }
        })
        .catch(console.log);
    },
    borrarCliente(id) {
      console.log(id);
      fetch("PHP/agencia.php/?borrar=" + id)
        .then((resp) => resp.json())
        .then((datosResp) => {
          console.log(datosResp);
          this.consultarClientes();
          //location.reload();
        })
        .catch(console.log);
    },
    almacenarCliente(cliente) {
      console.log(cliente);
      this.cliente_Almacenado = cliente;
    },
    añadirClienteRuta() {
      this.$router.push({ name: "AltaCliente" });
    },
    nuevaPolizaCliente(id) {
      this.$router.push({ name: "NuevaPolizaCliente", query: { id: id } });
    },
    async consultar_provincia() {
      const respuesta = await fetch("PHP/agencia.php/?consultar_provincias");
      const datosRespuesta = await respuesta.json();
      this.provincias = datosRespuesta;
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
        })
        .catch(console.log);
    },
  },
};
</script>
  
  <style>
#contenido {
  margin: 2em;
}
</style>
  