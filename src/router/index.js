import Vue from 'vue'
import App from './App.vue'
import router from './router'

import ListarCliente from '../components/ListarCliente.vue'

Vue.config.productionTip = false

// const routes = [
//   {
//     path: '/listarcliente',
//     name: 'ListarCliente',
//     component: ListarCliente
//   },
// ]

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
