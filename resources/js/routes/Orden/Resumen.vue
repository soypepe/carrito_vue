<template>
    <div class="w-full">
        <div class="lg:w-2/3 w-full mx-auto mt-8 overflow-auto">
            <h2
                class="text-sm title-font text-gray-500 tracking-widest"
                v-text="'Transaccion ID: ' + orden.transaccion_id"
            ></h2>
            <h1 class="text-gray-900 text-3xl title-font font-medium mb-4">Gracias por su compra</h1>
            <table class="table-auto w-full text-left whitespace-no-wrap">
                <thead>
                <tr>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200 rounded-tl rounded-bl">Item</th>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200">Cantidad</th>
                    <th class="px-4 py-3 title-font tracking-wider font-medium text-gray-900 text-sm bg-gray-200">Precio</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="item in orden.productos" :key="item.id">
                    <td class="p-4" v-text="item.nombre"></td>
                    <td class="p-4" v-text="item.pivot.cantidad"></td>
                    <td class="p-4" v-text="carroLineaTotal(item)"></td>
                </tr>
                <tr>
                    <td class="p-4 font-bold">Cargo Total</td>
                    <td class="p-4 font-bold" v-text="ordenCantidad"></td>
                    <td class="p-4 font-bold" v-text="ordenTotal"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    export default {
        methods: {
            carroLineaTotal(item) {
                let amount = item.precio * item.pivot.cantidad;
                amount = (amount / 100);
                return amount.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
            }
        },
        computed: {
            orden() {
              return this.$store.state.orden;
            },
            ordenCantidad() {
              return this.$store.state.orden.productos.reduce((acc, item) => acc + item.pivot.cantidad, 0);
            },
            ordenTotal() {
              // console.log($store.state.orden);
              let amount = this.$store.state.orden.productos.reduce((acc, item) => acc + (item.precio * item.pivot.cantidad), 0);
              amount = (amount / 100);
              return amount.toLocaleString('en-US', { style: 'currency', currency: 'USD' });
            }
        }
    }
</script>