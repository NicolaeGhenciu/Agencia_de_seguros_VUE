<template>
  <div id="contenido">
    <h3>
      Detalles del cliente, {{ cliente.nombre }}&nbsp;{{ cliente.apellidos }}
    </h3>
    <table id="tabla-clientes" class="table table-striped table-bordered">
      <thead class="thead-dark">
        <tr style="background-color: #d8f8e1">
          <th>Nombre</th>
          <th>Apellidos</th>
          <th>Teléfono</th>
          <th>Provincia</th>
          <th>Localidad</th>
          <th>Código Postal</th>
          <th>Entidad</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ cliente.nombre }}</td>
          <td>{{ cliente.apellidos }}</td>
          <td>{{ cliente.telefono }}</td>
          <td>{{ cliente.provincia_nombre }}</td>
          <td>{{ cliente.localidad }}</td>
          <td>{{ cliente.cp }}</td>
          <td>
            <span v-if="this.cliente_Almacenado.entidad === 'empresa'"
              ><i class="bi bi-building"></i> Empresa</span
            >
            <span v-else><i class="bi bi-person-fill"></i> Particular</span>
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
    <h3>Listado de polizas</h3>
    <button
      class="btn btn-success my-3"
      @click="nuevaPolizaCliente(cliente.id)"
    >
      <i class="bi bi-journal-plus"></i> Nueva poliza
    </button>
    <table id="tabla-polizas" class="table table-striped table-bordered">
      <thead class="thead-dark">
        <tr style="background-color: #cce5ff">
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
          :style="{
            backgroundColor:
              poliza.estado === 'liquidada'
                ? '#ffe4e1'
                : poliza.estado === 'anulada'
                ? '#ff6961'
                : poliza.estado === 'a_cuenta'
                ? '#84b6f4'
                : poliza.estado === 'cobrada'
                ? '#77dd77'
                : poliza.estado === 'pre-anulada'
                ? '#ffca99'
                : '',
          }"
        >
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
              v-if="poliza.estado && poliza.estado !== 'anulada'"
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
              <i class="bi bi-trash-fill"></i> Confirmación de anulacion de la
              poliza <b>{{ this.poliza_Almacenado.numero_poliza }}</b>
            </h5>
            <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            ¿Esta seguro de querer anular esta poliza?
            <p></p>
            <p>
              <b>Cliente: </b> {{ this.cliente.nombre }}&nbsp;{{
                this.cliente.apellidos
              }}
            </p>
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
    <button class="btn btn-warning" @click="$router.back()">
      <i class="bi bi-arrow-left"></i> Volver atras
    </button>
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
              order: [[2, "desc"]],
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
    nuevaPolizaCliente(id) {
      this.$router.push({ name: "NuevaPolizaCliente", query: { id: id } });
    },
  },
};
</script>