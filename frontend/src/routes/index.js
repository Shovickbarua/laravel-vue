import { createRouter, createWebHistory } from 'vue-router'
import ProductList from '../pages/product/ProductList.vue';
import ProductForm from '../pages/product/ProductForm.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', component:ProductList},
        { path: '/create', component: ProductForm },
        { path: '/edit/:id', name:'edit', component: ProductForm, props: true },
    ],
  });

  export default router;