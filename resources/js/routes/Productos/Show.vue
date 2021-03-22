<template>
  <section class="text-gray-700 body-font overflow-hidden" v-if="producto">
    <div class="container px-12 py-24 mx-auto">
      <div class="lg:w-3/5 mx-auto flex flex-wrap">
        <img src="https://dummyimage.com/640x640"
        alt="ecommerce image"
        class="lg:w-1/2 w-full lg:h-auto h-64 object-cover object-center rounded">
        <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
          <h2 class="text-sm title-font text-gray-500 tracking-widest uppercase inline-block mr-2"
          v-for="categoria in productos.categorias" :key="categoria.id"
          v-text="categoria.nombre"></h2>
          <h1
          class="text-gray-900 text-3xl title-font font-medium mb-2"
          v-text="producto.nombre"></h1>
          <p class="leading-relaxed"
          v-text="producto.descripcion"></p>
          <div class="flex mt-6 pt-4 border-t-2 border-gray-200">
            <span class="title-font font-medium text-2xl text-gray-900"
            v-text="formatoMoneda(producto.precio)"></span>
            <button
            class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded"
            @click="$store.commit('agregarAlCarro', producto)"
            >Agregar al Carro</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  methods: {
    formatoMoneda(precio){
      precio = precio/100;
      return precio.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
    }
  },
  computed: {
    productos() {
      return this.$store.state.productos;
    },
    producto() {
      return this.productos.find(producto => producto.slug == this.$route.params.slug);
    }
  }
}
</script>

<style>

</style>