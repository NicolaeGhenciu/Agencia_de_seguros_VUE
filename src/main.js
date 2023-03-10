import Vue from 'vue'
import App from './App.vue'

import VueRouter from 'vue-router'
import 'bootstrap/dist/css/bootstrap.css'
import 'datatables.net-bs5/css/dataTables.bootstrap5.css'
import 'datatables.net-bs5/js/dataTables.bootstrap5.js'
import 'datatables.net/js/jquery.dataTables.js'

import LoginUsuario from './components/LoginUsuario.vue'
import ListarCliente from './components/ListarCliente.vue'
import ListarPoliza from './components/ListarPoliza.vue'
import ListarPolizaFiltrado from './components/ListarPolizaFiltrado.vue'
import ListarFiltrado from './components/ListarFiltrado.vue'
import AltaCliente from './components/AltaCliente.vue'
import AltaPoliza from './components/AltaPoliza.vue'
import NuevaPolizaCliente from './components/NuevaPolizaCliente.vue'
import EditarCliente from './components/EditarCliente.vue'
import EditarPoliza from './components/EditarPoliza.vue'
import DetallesCliente from './components/DetallesCliente.vue'

Vue.use(VueRouter)

Vue.config.productionTip = false //esta linea desactiva mensaje en consola modo produccion o modo dev

const router = new VueRouter({
  routes: [
    {
      path: '/',
      name: 'LoginUsuario',
      component: LoginUsuario
    },
    {
      path: '/listarcliente',
      name: 'ListarCliente',
      component: ListarCliente,
      meta: { requiresAuth: true }
    },
    {
      path: '/listarpoliza',
      name: 'ListarPoliza',
      component: ListarPoliza,
      meta: { requiresAuth: true }
    },
    {
      path: '/listarpolizafiltrado',
      name: 'ListarPolizaFiltrado',
      component: ListarPolizaFiltrado,
      meta: { requiresAuth: true }
    },
    {
      path: '/listarfiltrado',
      name: 'ListarFiltrado',
      component: ListarFiltrado,
      meta: { requiresAuth: true }
    },
    {
      path: '/altacliente',
      name: 'AltaCliente',
      component: AltaCliente,
      meta: { requiresAuth: true }
    },
    {
      path: '/altapoliza',
      name: 'AltaPoliza',
      component: AltaPoliza,
      meta: { requiresAuth: true }
    },
    {
      path: '/nuevapolizacliente',
      name: 'NuevaPolizaCliente',
      component: NuevaPolizaCliente,
      meta: { requiresAuth: true }
    },
    {
      path: '/editarcliente',
      name: 'EditarCliente',
      component: EditarCliente,
      meta: { requiresAuth: true }
    },
    {
      path: '/editarpoliza',
      name: 'EditarPoliza',
      component: EditarPoliza,
      meta: { requiresAuth: true }
    },
    {
      path: '/detallescliente',
      name: 'DetallesCliente',
      component: DetallesCliente,
      meta: { requiresAuth: true }
    }
  ]
})

//let isLoggedIn = false;

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!localStorage.getItem('estoyLogueado')) {
      next({
        path: '/',
        query: { redirect: to.fullPath }
      })
    } else {
      next()
    }
  } else {
    next()
  }
})

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')