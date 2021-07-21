import { createWebHistory, createRouter } from 'vue-router';

import Home from "./views/Home.vue";
import LoginPage from './views/LoginPage.vue';
import Products from './views/Products.vue';
import Admin from './views/Admin.vue';
import ProductsCreate from './views/ProductsCreate.vue';
import ProductSingle from "./views/ProductSingle.vue";

import axios from 'axios';

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
        path: '/products/:id',
        name: 'ProductSingle',
        component: ProductSingle
    },
    {
        path: '/products/create',
        name: 'ProductsCreate',
        component: ProductsCreate,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/login',
        name: 'LoginPage',
        component: LoginPage
    },
    {
        path: '/admin',
        name: 'Admin',
        component: Admin,
        meta: {
            requiresAuth: true
        }
    },
];

const Router = createRouter({
    history: createWebHistory(),
    routes
});

// Checks routes for authentication guards.
Router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        axios.get('/api/auth')
            .then(res => {
                if (res.data.isOwner !== false) {
                    next();
                }
            })
    } else {
        next();
    }
});

export default Router;