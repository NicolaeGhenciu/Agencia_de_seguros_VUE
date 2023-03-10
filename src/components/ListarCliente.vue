<template>
  <div id="contenido">
    <h3>Lista de clientes</h3>
    <button class="btn btn-primary my-2" @click="añadirClienteRuta()">
      <i class="bi bi-person-fill-add"></i> Nuevo Cliente
    </button>
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
        <tr v-for="cliente in clientes" :key="cliente.id">
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
      clientes: [],
      cliente_Almacenado: [],
    };
  },
  created: function () {
    this.consultarClientes();
  },
  methods: {
    verDetalles(id) {
      this.$router.push({ name: "DetallesCliente", query: { id: id } });
    },
    editarCliente(id) {
      this.$router.push({ name: "EditarCliente", query: { id: id } });
    },
    consultarClientes() {
      let tabla = $("#tabla-clientes").DataTable();
      tabla.destroy(); // destruye la tabla existente

      fetch("PHP/agencia.php/?consultar_clientes")
        .then((respuesta) => respuesta.json())
        .then((datosRespuesta) => {
          console.log(datosRespuesta);
          this.clientes = [];
          if (typeof datosRespuesta[0].success === "undefined") {
            this.clientes = datosRespuesta;
          }
          this.$nextTick(function () {
            $("#tabla-clientes").DataTable({
              pageLength: 6,
              lengthMenu: [6, 10, 25, 50, 100],
            });
          });
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
  },
};
</script>

<style>
#contenido {
  margin: 2em;
}
</style>
