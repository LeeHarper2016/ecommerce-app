import { createApp } from 'vue';
import { createStore } from 'vuex';

import App from './App.vue';
import Router from './Router';

require('normalize.css');
require('../css/app.css');

const store = createStore({
    state() {
        return {
            user: null
        }
    },
    mutations: {
        setUser(state, user) {
            state.user = user;
        }
    }
})
createApp(App).use(Router)
    .use(store)
    .mount('#app');