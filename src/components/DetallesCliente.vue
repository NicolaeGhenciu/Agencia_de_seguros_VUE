<template>
  <div id="contenido">
    <h3>Detalles del cliente {{ cliente.id }}</h3>
    <table id="tabla-clientes" class="table table-striped table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Apellidos</th>
          <th>Teléfono</th>
          <th>Localidad</th>
          <th>Código Postal</th>
          <th>Provincia</th>
          <th>Entidad</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ cliente.id }}</td>
          <td>{{ cliente.nombre }}</td>
          <td>{{ cliente.apellidos }}</td>
          <td>{{ cliente.telefono }}</td>
          <td>{{ cliente.localidad }}</td>
          <td>{{ cliente.cp }}</td>
          <td>{{ cliente.provincia_nombre }}</td>
          <td>
            <span v-if="this.cliente_Almacenado.entidad === 'empresa'"
              >Empresa</span
            >
            <span v-else>Particular</span>
          </td>
          <td>
            <button class="btn btn-warning" @click="editarCliente(cliente.id)">
              <i class="bi bi-pencil-square"></i></button
            >&nbsp;<button
              type="button"
              class="btn btn-danger"
              data-bs-toggle="modal"
              data-bs-target="#staticBackdrope"
              @click="almacenarCliente(cliente)"
            >
              <i class="bi bi-trash-fill"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
    <hr />
    <h2>Listado de polizas</h2>
    <table id="tabla-polizas" class="table table-striped table-bordered">
      <thead class="thead-dark">
        <tr>
          <th>ID</th>
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
          v-for="poliza in polizas"
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
          <td>{{ poliza.numero_poliza }}</td>
          <td>{{ poliza.importe_recibo }}</td>
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
              v-if="poliza.estado"
            >
              <i class="bi bi-pencil-square"></i></button
            >&nbsp;
            <button
              type="button"
              class="btn btn-danger border border-dark"
              data-bs-toggle="modal"
              data-bs-target="#staticBackdrop"
              @click="almacenarPoliza(poliza)"
              v-if="poliza.estado"
            >
              <i class="bi bi-trash-fill"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
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
            <b>{{ this.poliza_Almacenado.id }}</b>
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
    <!-- Modal -->
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
              <i class="bi bi-trash-fill"></i> Confirmación de baja de cliente
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            ¿Esta seguro de querer dar de baja al cliente
            <b>{{ this.cliente_Almacenado.id }}</b> ?
            <p><b>Nombre:</b> {{ this.cliente_Almacenado.nombre }}</p>
            <p><b>Apellidos:</b> {{ this.cliente_Almacenado.apellidos }}</p>
            <p><b>Teléfono:</b> {{ this.cliente_Almacenado.telefono }}</p>
            <p><b>Localidad:</b> {{ this.cliente_Almacenado.localidad }}</p>
            <p><b>Código Postal:</b> {{ this.cliente_Almacenado.cp }}</p>
            <p><b>Provincia:</b> {{ this.cliente_Almacenado.provincia }}</p>
            <p>
              <b>Entidad: </b>
              <span v-if="this.cliente_Almacenado.entidad === 'empresa'"
                >Empresa</span
              >
              <span v-else>Particular</span>
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
  </div>
</template>

<script>
import $ from "jquery";
import "datatables.net";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap/dist/js/bootstrap.bundle.min.js";

export default {
  data() {
    return {
      cliente: {},
      polizas: [],
      poliza_Almacenado: [],
      cliente_Almacenado: [],
    };
  },
  filters: {
    date: function (value) {
      if (!value) return "";
      return new Date(value).toLocaleDateString("es-ES");
    },
  },
  created() {
    this.fetchClienteDetails();
    this.fetchPolizaDetails();
  },
  methods: {
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
          this.fetchPolizaDetails();
        })
        .catch(console.log);
    },
    almacenarPoliza(poliza) {
      console.log(poliza);
      this.poliza_Almacenado = poliza;
    },
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
    fetchPolizaDetails() {
      let tabla = $("#tabla-polizas").DataTable();
      tabla.destroy(); // destruye la tabla existente
      let clienteId = this.$route.query.id;
      fetch("PHP/agencia.php/?consultar_poliza=" + clienteId)
        .then((response) => response.json())
        .then((data) => {
          console.log(data);
          this.polizas = data;
          this.$nextTick(function () {
            $("#tabla-polizas").DataTable({
              pageLength: 5,
              lengthMenu: [5, 10, 25, 50, 100],
              order: [[3, "desc"]],
            });
          });
        })
        .catch((error) => {
          console.error(error);
        });
    },
    borrarCliente(id) {
      console.log(id);
      fetch("PHP/agencia.php/?borrar=" + id)
        .then((resp) => resp.json())
        .then((datosResp) => {
          console.log(datosResp);
          //this.consultarClientes();
          this.$router.push({ name: "ListarCliente" });
        })
        .catch(console.log);
    },
    almacenarCliente(cliente) {
      console.log(cliente);
      this.cliente_Almacenado = cliente;
    },
  },
};
</script>