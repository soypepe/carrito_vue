require('./bootstrap');

import Vue from 'vue';

import Vuex from 'vuex';
Vue.use(Vuex);

import VueRouter from 'vue-router';
import axios from 'axios';
Vue.use(VueRouter);

const router = new VueRouter({
  mode: 'history',
  routes: require('./routes.js')
});

const store = new Vuex.Store({
  state: {
    productos: [],
    carro: [],
    orden: {}
  },
  mutations: {
    updateProductos(state, productos){
      state.productos = productos;
    },
    agregarAlCarro(state, producto){
      let productoEnCarroIndex = state.carro.findIndex(item => item.slug == producto.slug);
      if(productoEnCarroIndex != -1){
        state.carro[productoEnCarroIndex].cantidad++;
        return;
      }

      producto.cantidad = 1;
      state.carro.push(producto);
    },
    eliminarDelCarro(state, index){
      state.carro.splice(index, 1);
    },
    updateOrden(state, orden){
      state.orden = orden;
    },
    updateCarro(state, carro){
      state.carro = carro;
    }
  },
  actions: {
    getProductos({ commit }){
      axios.get('/api/productos')
        .then((response) => {
          commit('updateProductos', response.data);
        })
        .catch((error) => console.error(error));
    },
    limpiarCarro({ commit }){
      commit('updateCarro', []);
    }
  }
});

const app = new Vue({
  router,
  store,
  el: '#app',
  created() {
    store.dispatch('getProductos')
      .then(_ => {})
      .catch((error) => console.error(error));
  }
});
