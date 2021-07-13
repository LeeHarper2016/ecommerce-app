import { createWebHistory, createRouter } from 'vue-router';

import Products from './views/Products.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: null
    },
    {
        path: '/products',
        name: 'Products',
        component: Products
    },
];

const Router = createRouter({
    history: createWebHistory(),
    routes
});

export default Router;