import { createWebHistory, createRouter } from 'vue-router';

import Home from "./views/Home.vue";
import LoginPage from './views/LoginPage.vue';
import Products from './views/Products.vue';

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home
    },
    {
        path: '/products',
        name: 'Products',
        component: Products
    },
    {
        path: '/login',
        name: 'LoginPage',
        component: LoginPage
    },
];

const Router = createRouter({
    history: createWebHistory(),
    routes
});

export default Router;