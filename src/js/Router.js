import { createWebHistory, createRouter } from 'vue-router';

import Home from "./views/Home.vue";
import LoginPage from './views/LoginPage.vue';
import Products from './views/Products.vue';
import axios from "axios";

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

// Checks routes for authentication guards.
Router.beforeEach((to, from, next) => {
    if (to.matched.some((record) => record.meta.requiresAuth)) {
        axios.get('/api/auth')
            .then(res => {
                console.log(res.data);
                if (res.data.isOwner !== false) {
                    next();
                }
            })
    } else {
        next();
    }
});

export default Router;