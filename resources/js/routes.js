module.exports = [
  {
    path: '/',
    name: 'productos.index',
    component: () => import('./routes/Productos/Index.vue')
  },
  {
    path: '/producto/:slug',
    name: 'productos.show',
    component: () => import('./routes/Productos/Show.vue')
  },
  {
    path: '/checkout',
    name: 'orden.checkout',
    component: () => import('./routes/Orden/Checkout.vue')
  },
  {
    path: '/resumen',
    name: 'orden.resumen',
    component: () => import('./routes/Orden/Resumen.vue')
  }
]