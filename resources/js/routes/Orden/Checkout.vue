<template>
  <div w-full>
    <div class="lg:w-2/3 w-full mx-auto mt-8 overflow auto">
      <table class="table-auto w-full text-left whitespace-no-wrap">
        <thead>
          <tr>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200 rounded-tl rounded-bl">Item</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200">Cantidad</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200">Precio</th>
            <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, index) in carro" :key="item.id">
            <td class="p-4" v-text="item.nombre"></td>
            <td class="p-4" v-text="item.cantidad"></td>
            <td class="p-4" v-text="carroClienteTotal(item)"></td>
            <td class="w-10 text-right">
              <button class="flex ml-auto text-sm text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-700 rounded"
              @click="$store.commit('eliminarDelCarro', index)">Eliminar</button>
            </td>
          </tr>
          <tr>
            <td class="p-4 font-bold">Costo Total</td>
            <td class="p-4 font-bold" v-text="carroCantidad"></td>
            <td class="p-4 font-bold" v-text="carroTotal"></td>
            <td class="w-10 text-right"></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="lg:w-2/3 w-full mx-auto mt-8">
      <div class="flex flex-wrap -mx-2 mt-8">
        <div class="p-2 w-1/3">
          <div class="relative">
            <label for="nombre" class="leading-7 text-sm text-gray-600">Nombre</label>
            <input type="text" id="nombre" name="nombre"
            class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
            v-model="cliente.nombre"
            :disabled="procesandoPago">
          </div>
        </div>
        <div class="p-2 w-1/3">
          <div class="relative">
            <label for="apellido" class="leading-7 text-sm text-gray-600">Apellido</label>
            <input type="text" id="apellido" name="apellido"
            class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
            v-model="cliente.apellido"
            :disabled="procesandoPago">
          </div>
        </div>
        <div class="p-2 w-1/3">
          <div class="relative">
            <label for="correo" class="leading-7 text-sm text-gray-600">Correo</label>
            <input type="email" id="correo" name="correo"
            class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
            v-model="cliente.correo"
            :disabled="procesandoPago">
          </div>
        </div>
        <div class="p-2 w-1/3">
          <div class="relative">
            <label for="direccion" class="leading-7 text-sm text-gray-600">Direccion</label>
            <input type="text" id="direccion" name="direccion"
            class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
            v-model="cliente.direccion"
            :disabled="procesandoPago">
          </div>
        </div>
        <div class="p-2 w-1/3">
          <div class="relative">
            <label for="ciudad" class="leading-7 text-sm text-gray-600">Ciudad</label>
            <input type="text" id="ciudad" name="ciudad"
            class="w-full bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out"
            v-model="cliente.ciudad"
            :disabled="procesandoPago">
          </div>
        </div>
      </div>
      <div class="flex flex-wrap -mx-2 -mt-4">
        <div class="p-2 w-full">
          <div class="relative">
            <label for="tarjeta_elemento" class="leading-7 text-sm text-gray-600">Informacion de Tarjeta de Credito</label>
            <div id="card-element"></div>
          </div>
        </div>
        <div class="p-2 w-full">
          <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-700"
          @click="procesarPago"
          :disabled="procesandoPago"
          v-text="procesandoPago ? 'Procesando' : 'Page Ahora'"></button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { loadStripe } from '@stripe/stripe-js';
export default {
  data() {
    return {
      stripe: {},
      cardElement: {},
      cliente: {
        nombre: '',
        apellido: '',
        correo: '',
        direccion: '',
        ciudad: '',
      },
      procesandoPago: false
    }
  },
  async mounted() {
    this.stripe = await loadStripe(process.env.MIX_STRIPE_KEY);
    const elements = this.stripe.elements();
    this.cardElement = elements.create('card', {
      classes: {
          base: 'bg-gray-100 rounded border border-gray-300 focus:border-indigo-500 text-base outline-none text-gray-700 p-3 leading-8 transition-colors duration-200 ease-in-out'
      }
    });
    this.cardElement.mount('#card-element');
  },
  methods: {
    carroClienteTotal(item){
      let amount = item.precio * item.cantidad;
      amount = (amount / 100);
      return amount.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    },
    async procesarPago(){
      this.paymentProcessing = true;

      const {paymentMethod, error} = await this.stripe.createPaymentMethod(
        'card', this.cardElement, {
          billing_details: {
            name: this.cliente.nombre + ' ' + this.cliente.apellido,
            email: this.cliente.email,
            address: {
              line1: this.cliente.direccion,
              city: this.cliente.ciudad,
            }
          }
        }
      );
      if(error){
        this.paymentProcessing = false;
        console.error(error);
      } else{
        // console.log(paymentMethod);
        this.cliente.payment_method_id = paymentMethod.id;
        this.cliente.amount = this.$store.state.carro.reduce((acc, item) => acc + (item.precio * item.cantidad), 0);
        this.cliente.cart = JSON.stringify(this.$store.state.carro);
        console.log(this.cliente);

        axios.post('/api/compra', this.cliente)
          .then((response) => {
            console.log(response);
            this.paymentProcessing = false;

            this.$store.commit('updateOrden', response.data);
            console.log('despues de updateorden');
            this.$store.dispatch('limpiarCarro');
            console.log('despues de clearcarro');

            this.$router.push({ name: 'orden.resumen' });
            console.log('despues de router');
          })
          .catch((error) => {
            this.procesandoPago = false;
            console.log(error.response.data);
          })
      }
    }
  },
  computed: {
    carro() {
      return this.$store.state.carro;
    },
    carroCantidad() {
      return this.$store.state.carro.reduce((acc, item) => acc + item.cantidad, 0);
    },
    carroTotal() {
      let amount = this.$store.state.carro.reduce((acc, item) => acc + (item.precio * item.cantidad), 0);
      amount = (amount / 100);
      return amount.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    }
  }
}
</script>

<style>

</style>